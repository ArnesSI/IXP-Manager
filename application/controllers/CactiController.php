<?php

/*
 * Copyright (C) 2009-2011 Internet Neutral Exchange Association Limited.
 * All Rights Reserved.
 * 
 * This file is part of IXP Manager.
 * 
 * IXP Manager is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, version v2.0 of the License.
 * 
 * IXP Manager is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 * 
 * You should have received a copy of the GNU General Public License v2.0
 * along with IXP Manager.  If not, see:
 * 
 * http://www.gnu.org/licenses/gpl-2.0.html
 */


/*
 *
 *
 * http://www.inex.ie/
 * (c) Internet Neutral Exchange Association Ltd
 */

class CactiController extends INEX_Controller_Action
{

    /**
     * Override the INEX_Controller_Action's constructor (which is called
     * at the very end of this function anyway).
     *
     * @param object $request See Parent class constructer
     * @param object $response See Parent class constructer
     * @param object $invokeArgs See Parent class constructer
     */
    public function __construct(
            Zend_Controller_Request_Abstract  $request,
            Zend_Controller_Response_Abstract $response,
            array $invokeArgs = null )
    {
        // get the bootstrap object
        $this->_bootstrap = $invokeArgs['bootstrap'];

        // and from the bootstrap, we can get other resources:
        $this->config  = $this->_bootstrap->getApplication()->getOptions();
        $this->_bootstrap->getResource( 'namespace' );
        $this->logger  = $this->_bootstrap->getResource( 'logger' );

        $this->auth    = $this->_bootstrap->getResource( 'auth' );

        if( $this->auth->hasIdentity() )
        {
            $this->identity = $this->auth->getIdentity();
            $this->user     = Doctrine::getTable( 'User' )->find( $this->identity['user']['id'] );
            $this->customer = Doctrine::getTable( 'Cust' )->find( $this->identity['user']['custid'] );
        }
        else
        {
            $this->logger->err( "Request for Cacti graph by unauthenticated user" );
            die();
        }

        if( $this->getGraphingClass() != "Arnes_Cacti" )
            die();

        // call the parent's version where all the Zend magic happens
        parent::__construct( $request, $response, $invokeArgs );
    }

    private function checkShortname( $shortname )
    {
        return Doctrine::getTable( 'Cust' )->findByShortname( $shortname );
    }

    public function retrieveImageAction()
    {
        header( 'Content-Type: image/png' );
        header( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );

        $switchport   = $this->getRequest()->getParam( 'switchport', 'aggregate' );
        $monitorindex = $this->getRequest()->getParam( 'monitorindex', 'aggregate' );
        $period       = $this->getRequest()->getParam( 'period', 'day' );
        $shortname    = $this->getRequest()->getParam( 'shortname' );
        $category     = $this->getRequest()->getParam( 'category', 'bits' );
        $graph        = $this->getRequest()->getParam( 'graph', '' );
        $graphMini    = $this->getRequest()->getParam( 'mini', 0 );

        $this->logger->debug( "Request for graph: $shortname-$monitorindex-$category-$period-$graph-$switchport by {$this->user->username}" );
        if( !$shortname )
        {
            $this->logger->err( "Missing mandatory parameter shortname" );
            $this->_printImageMissing();
            die();
        }
        

        if( !$this->identity )
            exit(0);

        $customer = null;
        $graphTitle = null;
        $interface = null;
        $switchName = null;
        $portName = null;
        $requestValid = false;

        // generate small (preview) or full size graph
        if( $graphMini == 1 )
            $graphMini = true;
        else
            $graphMini = false;

        // determine what type of graph was requested
        if( $shortname == 'X_Trunks' )
        {
            // make sure the graph requested is actually in configuration
            foreach( $this->config['mrtg']['trunk_graphs'] as $g )
            {
                $p = explode( '::', $g );
                $graphs[] = $p[0];
            }
            if( in_array($graph, $graphs) )
            {
                $portName = 'X_Trunks';
                $category = 'bits';
                $requestValid = true;
                list( $switchName, $graphTitle ) = explode('_', $graph, 2);
            }
        }
        else if( $shortname == 'X_SwitchAggregate' )
        {
            // werify the switch exists in DB
            if( Doctrine::getTable( 'SwitchTable' )->findOneByName($graph) )
            {
                $portName   = 'X_SwitchAggregate';
                $requestValid = true;
                $switchName = $graph;
            }
        }
        else if( $shortname == 'X_Peering' )
        {
            // make sure the graph requested is actually in configuration
            foreach( $this->config['mrtg']['traffic_graphs'] as $g )
            {
                $p = explode( '::', $g );
                $graphs[]      = $p[0];
            }
            if( in_array($graph, $graphs) )
            {
                $portName   = 'X_Peering';
                $requestValid = true;
                $graphTitle = $graph;
            }
        }
        else
        {
            if( $this->user['privs'] < User::AUTH_SUPERUSER || !$this->checkShortname( $shortname ) )
                $shortname = $this->customer['shortname'];

            // translate shortname to AS number
            $customer = Doctrine::getTable( 'Cust' )->findOneByShortname($shortname);
            $graphTitle = 'AS'.$customer['autsys'];

            if( $monitorindex == "aggregate" )
                $switchport = "aggregate";

            // verify that the interface requested belongs to this customer's connection
            // and set switch and port name accordingly
            if( $switchport != 'aggregate' && $customer )
            {
                foreach( $customer->getConnections() as $connection )
                {
                    foreach( $connection->Physicalinterface as $interface )
                    {
                        if( $interface->Switchport->id == $switchport )
                        {
                            $portName = $interface->Switchport->name;
                            $switchName = $interface->Switchport->SwitchTable->name;
                            $requestValid = true;
                            break 2;
                        }
                    }
                }
            }
            elseif( $switchport == 'aggregate' && $customer )
                $requestValid = true;
            else
                $requestValid = false;
        }

        // the correct combination of graph parameters was not found
        if( $requestValid == false )
        {
            $this->logger->err( "Invalid combination of graph request parameters: $shortname-$monitorindex-$category-$period-$graph-$switchport" );
            $this->_printImageMissing();
            exit;
        }

        /* output of this function is expected to be an image
         * so we cannot return the generic error message to the user on exceptions
         */
        try
        {
            $cacti_path = $this->config['cacti']['path'];
            $cacti_user = $this->config['cacti']['user'];
            $cacti_pass = $this->config['cacti']['pass'];
            $cacti = new Arnes_Cacti($cacti_path, $cacti_user, $cacti_pass);
            $id = $cacti->findGraph($graphTitle, $switchName, $portName, $category);
            $this->logger->debug("Getting graph id: $id from Cacti");
            $data = $cacti->getGraph($id, $period, $graphMini);
        }
        catch(Exception $e) {
            $this->logger->err( "Could not load graph $shortname-$switchport-$category-$period from Cacti" );
            $this->logger->err( $e );
            $this->_printImageMissing();
            exit;
        }

        echo $data;
        // to prevent sending any footer html
        exit;
    }

    private function _printImageMissing()
    {
        echo readfile(
            APPLICATION_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR
                . 'image-missing.png'
        );
    }
}


