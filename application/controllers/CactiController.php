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
        $period       = $this->getRequest()->getParam( 'period', 'day' );
        $shortname    = $this->getRequest()->getParam( 'shortname' );
        $category     = $this->getRequest()->getParam( 'category', 'bits' );
        $graph        = $this->getRequest()->getParam( 'graph', '' );

        $this->logger->debug( "Request for graph: $shortname-$switchport-$category-$period by {$this->user->username}" );
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

        if( $shortname == 'X_Trunks' )
        {
            $filename = $this->config['mrtg']['path']
                . '/../trunks/' . $graph . '-' . $period . '.png';
        }
        else if( $shortname == 'X_SwitchAggregate' )
        {
            $filename = $this->config['mrtg']['path']
                . '/../switches/switch-aggregate-' . $graph . '-'
                . $category . '-' . $period . '.png';
        }
        else if( $shortname == 'X_Peering' )
        {
            $filename = $this->config['mrtg']['path']
                . '/../inex_peering-' . $graph . '-'
                . $category . '-' . $period . '.png';
        }
        else
        {
            if( $this->user['privs'] < User::AUTH_SUPERUSER || !$this->checkShortname( $shortname ) )
                $shortname = $this->customer['shortname'];

            // translate shortname to AS number
            $customer = Doctrine::getTable( 'Cust' )->findOneByShortname($shortname);
            $graphTitle = 'AS'.$customer['autsys'];

            // verify that the interface requested belongs to this customers connection
            // and set switch name and port name accordingly
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
                            break 2;
                        }
                    }
                }
                // the correct connection was not found
                if( is_null($portName) )
                {
                    $this->logger->err( "Could not match Cust $shortname to SwitchPort ID $switchport while loading graph" );
                    $this->_printImageMissing();
                    exit;
                }
            }
        }

        /* output of this function is expected to be an image
         * so we cannot return the generic error message to the user on exceptions
         */
        try
        {
            // FIXME put these in configuration file
            $cacti_url = 'http://<host>/cacti/soap_service.php';
            $cacti_user = 'ixp_manager';
            $cacti_pass = '<password>';
            $cacti = new Arnes_Cacti($cacti_url, $cacti_user, $cacti_pass);
            $id = $cacti->findGraph($graphTitle, $switchName, $portName, $category);
            $this->logger->debug("Getting graph id: $id from Cacti");
            $data = $cacti->getGraph($id, $period);
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


