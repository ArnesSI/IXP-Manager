<?php


/*
 * Copyright (C) 2011 Arnes.
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

/**
 * Cacti - Get graphs from Cacti
 *
 *  @package Arnes_Cacti
 */
class Arnes_Cacti extends Zend_Soap_Client
{

    private $endtime = null;


    /**
     * Period of one day for MRTG data/graphs
     * @see Arnes_Cacti::$PERIOD_TIME
     */
    const PERIOD_DAY   = 'day';

    /**
     * Period of one week for MRTG data/graphs
     * @see Arnes_Cacti::$PERIOD_TIME
     */
    const PERIOD_WEEK  = 'week';

    /**
     * Period of one month for MRTG data/graphs
     * @see Arnes_Cacti::$PERIOD_TIME
     */
    const PERIOD_MONTH = 'month';

    /**
     * Period of one year for MRTG data/graphs
     * @see Arnes_Cacti::$PERIOD_TIME
     */
    const PERIOD_YEAR  = 'year';

    /**
     * Array of valid periods for drill down graphs
     */
    public static $PERIODS = array(
        'day'   => Arnes_Cacti::PERIOD_DAY,
        'week'  => Arnes_Cacti::PERIOD_WEEK,
        'month' => Arnes_Cacti::PERIOD_MONTH,
        'year'  => Arnes_Cacti::PERIOD_YEAR
    );


    /**
     * Period times.
     *
     * these values are taken from default Cacti RRA definitions
     */
    public static $PERIOD_TIME = array(
        'day'   => 86400,
        'week'  => 604800,
        'month' => 2678400,
        'year'  => 33053184
    );


    /**
     * 'Bits' graph template id for Cacti graphs
     */
    const TEMPLATE_BITS     = 2;

    /**
     * 'Packets' graph template id for Cacti graphs
     */
    const TEMPLATE_PACKETS  = 23;

    /**
     * 'Errors' graph template id for Cacti graphs (this graph includes discards)
     */
    const TEMPLATE_ERRORS   = 22;

    /**
     * 'Optical power (DOM)' graph template id for Cacti graphs
     */
    const TEMPLATE_OPTICS   = 85;

    /**
     * Array of valid template ids for graphs
     */
    public static $TEMPLATES = array(
        'bits'     => Arnes_Cacti::TEMPLATE_BITS,
        'packets'  => Arnes_Cacti::TEMPLATE_PACKETS,
        'errors'   => Arnes_Cacti::TEMPLATE_ERRORS,
        'optics'   => Arnes_Cacti::TEMPLATE_OPTICS
    );

    /**
     * Array of valid template ids for aggregate graphs
     */
    public static $TEMPLATES_AGGREGATE = array(
        'bits'     => Arnes_Cacti::TEMPLATE_BITS,
        'packets'  => Arnes_Cacti::TEMPLATE_PACKETS
    );


    /**
     * Sets Cacti SOAP server base URL and authentication data
     */
    public function __construct( $location, $username, $password )
    {
        parent::__construct(null, array(
            'uri' => 'urn:pc_SOAP_return_soap',
            'location' => $location,
        ));
        /* Arnes Cacti SOAP server uses its own braindead authentication implementation
         * Need to work around it here.
         */
        $this->addSoapInputHeader(new SOAPHeader(
                'urn:pc_SOAP_return_soap', 
                'authenticate_user',
                (object) array( 'username' => $username, 'password' => $password )
            ), true
        );
    }

    /**
     * Finds graphs in Cacti
     * Translates IXP Manager's search parameters to Cacti's.
     * 
     * @param $graphTitle string Substring match on graph title. Usually AS number
     * @param $switchName string Name of the switch
     * @param $portName string Name of the interface or 'aggregate'
     * @param $category string A key from Arnes_Cacti::$TEMPLATES
     * @return integer ID of the graph found
     */
    public function findGraph( $graphTitle = '',
            $switchName = '',
            $portName = 'aggregate',
            $category = 'bits'
        )
    {

        if( !$portName )
            $portName = 'aggregate';
        if( !$category || !array_key_exists( $category, Arnes_Cacti::$TEMPLATES ) )
            $category = 'bits';

        $searchParam = array();

        // aggregate graph have no template or interface, can search only on title
        if ( $portName == 'aggregate' )
        {
            $searchParam['graph_title'] = sprintf('SIX - %%(%s)%%(stacked)', $graphTitle);
            if ( !array_key_exists( $category, Arnes_Cacti::$TEMPLATES_AGGREGATE ) )
                $category = 'bits';
        }
        else
        {
            $searchParam['graph_title'] = sprintf('%%(%s)%%', $graphTitle);
            $searchParam['host_description'] = $switchName;
            $searchParam['data_query_field_value'] = $portName;
            $searchParam['template_id'] = Arnes_Cacti::$TEMPLATES[$category];
        }

        $result = $this->return_IDs_find_Graphs( $searchParam );
        if( !is_array($result['Result']) || count($result['Result']) < 1 )
            throw new INEX_Exception( 'Graph not found in Cacti' );
        // TODO warn if more than one result returned
        return $result['Result'][0];
    }

    /**
     * Returns an image for a given graph
     * 
     * @param $graphId int Cacti ID of the graph
     * @param $period string Key from Arnes_Cacti::$PERIODS
     * @return bin Graph image
     */
    public function getGraph( $graphId, $period )
    {
        if( !array_key_exists($period, Arnes_Cacti::$PERIOD_TIME) )
            $period = 'day';

        $now = time();
        $extraParam = array(
            'graph_start' => $now-Arnes_Cacti::$PERIOD_TIME[$period],
            'graph_end'   => $now
        );
        
        $result = $this->return_bin_get_Graph_Image_By_graphID($graphId, $extraParam);

        $data = $result['Result'];
        $data = base64_decode($data);
        return $data;
    }
}
