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
        'Day'   => Arnes_Cacti::PERIOD_DAY,
        'Week'  => Arnes_Cacti::PERIOD_WEEK,
        'Month' => Arnes_Cacti::PERIOD_MONTH,
        'Year'  => Arnes_Cacti::PERIOD_YEAR
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
     * 'Bits' category for Cacti graphs
     */
    const CATEGORY_BITS = 'bits';

    /**
     * 'Packets' category for Cacti graphs
     */
    const CATEGORY_PACKETS = 'pkts';

    /**
     * 'Errors' category for Cacti graphs
     */
    const CATEGORY_ERRORS = 'errs';

    /**
     * 'Optical power (DOM)' category for Cacti graphs
     */
    const CATEGORY_OPTICS = 'optics';


    /**
     * 'Bits' graph template id for Cacti graphs
     */
    const TEMPLATE_BITS = 2;

    /**
     * 'Packets' graph template id for Cacti graphs
     */
    const TEMPLATE_PACKETS = 23;

    /**
     * 'Errors' graph template id for Cacti graphs (this graph includes discards)
     */
    const TEMPLATE_ERRORS = 22;

    /**
     * 'Optical power (DOM)' graph template id for Cacti graphs
     */
    const TEMPLATE_OPTICS = 85;

    /**
     * Array of valid template ids for graphs
     */
    public static $TEMPLATES = array(
        'bits'     => Arnes_Cacti::TEMPLATE_BITS,
        'pkts'     => Arnes_Cacti::TEMPLATE_PACKETS,
        'errs'     => Arnes_Cacti::TEMPLATE_ERRORS,
        'optics'   => Arnes_Cacti::TEMPLATE_OPTICS
    );

    /**
     * Array of valid categories for graphs
     */
    public static $CATEGORIES = array(
        'Bits'          => Arnes_Cacti::CATEGORY_BITS,
        'Packets'       => Arnes_Cacti::CATEGORY_PACKETS,
        'Errors'        => Arnes_Cacti::CATEGORY_ERRORS,
        'Optical Power' => Arnes_Cacti::CATEGORY_OPTICS
    );

    /**
     * Array of valid categories for aggregate graphs
     */
    public static $CATEGORIES_AGGREGATE = array(
        'Bits'          => Arnes_Cacti::CATEGORY_BITS,
        'Packets'       => Arnes_Cacti::CATEGORY_PACKETS,
    );

    /**
     * When searching for graphs, graph title must contain one of these strings.
     * Based on type of graph.
     */
    public static $TITLES_AGGREGATE = array(
        'bits' => "Traffic",
        'pkts' => "Packets"
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

        // whit type of graph was requested
        switch( $portName ) {
            case 'aggregate':
                // aggregate graphs have no template or interface, can search only on title
                if ( !array_key_exists( $category, Arnes_Cacti::$TITLES_AGGREGATE ) )
                    $category = 'bits';
                $searchParam['graph_title'] = sprintf('SIX - Total %s - %%(%s)', Arnes_Cacti::$TITLES_AGGREGATE[$category], $graphTitle);
                break;
            case 'X_Trunks':
                $searchParam['host_description'] = $switchName;
                $searchParam['data_query_field_value'] = $graphTitle;
                $searchParam['template_id'] = Arnes_Cacti::$TEMPLATES[$category];
                break;
            case 'X_SwitchAggregate':
                if ( !array_key_exists( $category, Arnes_Cacti::$TITLES_AGGREGATE ) )
                    $category = 'bits';
                $searchParam['graph_title'] = sprintf('SIX - %s - Switch Total %s', $switchName, Arnes_Cacti::$TITLES_AGGREGATE[$category]);
                break;
            case 'X_Peering':
                $searchParam['graph_title'] = sprintf('%s - Total %s', $graphTitle, Arnes_Cacti::$TITLES_AGGREGATE[$category]);
                break;
            default:
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
     * @param $mini bool Adjust parameters to generate small (preview) graphs
     * @return bin Graph image
     */
    public function getGraph( $graphId, $period, $mini = true )
    {
        if( !array_key_exists($period, Arnes_Cacti::$PERIOD_TIME) )
            $period = 'day';

        $now = time();
        $extraParam = array(
            'graph_start'    => $now - Arnes_Cacti::$PERIOD_TIME[$period],
            'graph_end'      => $now,
        );

        if( !( $mini === true || $mini === false ) )
            $mini = false;
        if( $mini )
        {
            $extraParam['graph_nolegend'] = true;
            $extraParam['graph_width']    = 197;
            $extraParam['graph_height']   = 100;
        }

        $result = $this->return_bin_get_Graph_Image_By_graphID($graphId, $extraParam);

        $data = $result['Result'];
        $data = base64_decode($data);
        return $data;
    }

    /**
     * Utility function to generate URLs for grabbing graph images.
     *
     * FIXME This isn't the right place for this but I'm not sure what is
     *       right now.
     * Taken from INEX/Mrtg.php
     *
     * @param array $params Array of parameters to make up the URL
     * @return string The URL
     */
    public static function generateZendFrontendUrl( $params )
    {
        $url = Zend_Controller_Front::getInstance()->getBaseUrl()
            . '/cacti/retrieve-image';

        if( isset( $params['shortname'] ) )
            $url .= "/shortname/{$params['shortname']}";

        if( isset( $params['switchport'] ) )
            $url .= "/switchport/{$params['switchport']}";

        if( isset( $params['monitorindex'] ) )
            $url .= "/monitorindex/{$params['monitorindex']}";
        else
            $url .= "/monitorindex/aggregate";

        if( isset( $params['period'] ) )
            $url .= "/period/{$params['period']}";
        else
            $url .= "/period/day";

        if( isset( $params['category'] ) )
            $url .= "/category/{$params['category']}";
        else
            $url .= "/category/bits";

        if( isset( $params['mini'] ) )
            $url .= "/mini/{$params['mini']}";

        if( isset( $params['graph'] ) )
            $url .= "/graph/{$params['graph']}";

        return $url;
    }

}
