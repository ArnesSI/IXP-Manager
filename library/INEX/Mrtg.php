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

/**
 * MRTG - Nick's MRTG Class
 *
 * http://www.inex.ie/
 *
 * 20081126 Nick's latest version
 * 20100219 Ported to IXP Manager by barryo
 *
 *
 *  @package INEX_Mrtg
 */
class INEX_Mrtg
{

    private $file = null;

    private $endtime = null;

    /**
     * Array of MRTG data from the file
     * @var array
     */
    private $array = null;


    /**
     * Period of one day for MRTG data/graphs
     * @see INEX_Mrtg::$PERIOD_TIME
     */
    const PERIOD_DAY   = 'day';

    /**
     * Period of one week for MRTG data/graphs
     * @see INEX_Mrtg::$PERIOD_TIME
     */
    const PERIOD_WEEK  = 'week';

    /**
     * Period of one month for MRTG data/graphs
     * @see INEX_Mrtg::$PERIOD_TIME
     */
    const PERIOD_MONTH = 'month';

    /**
     * Period of one year for MRTG data/graphs
     * @see INEX_Mrtg::$PERIOD_TIME
     */
    const PERIOD_YEAR  = 'year';

    /**
     * Array of valid periods for drill down graphs
     */
    public static $PERIODS = array(
        'Day'   => INEX_Mrtg::PERIOD_DAY,
        'Week'  => INEX_Mrtg::PERIOD_WEEK,
        'Month' => INEX_Mrtg::PERIOD_MONTH,
        'Year'  => INEX_Mrtg::PERIOD_YEAR
    );


    /**
     * Period times.
     *
     * these values are taken from mrtg/src/rateup.c
     */
    public static $PERIOD_TIME = array(
        'day'   => 119988.0,     //( 33.33 * 3600 ),
        'week'  => 719712.0,     // ( 8.33  * 24 * 3600 ),
        'month' => 2879712.0,    // ( 33.33 * 24 * 3600 ),
        'year'  => 31622400.0    // ( 366 * 24 * 3600 )
    );


    /**
     * 'Bits' category for MRTG data and graphs
     */
    const CATEGORY_BITS     = 'bits';

    /**
     * 'Packets' category for MRTG data and graphs
     */
    const CATEGORY_PACKETS  = 'pkts';

    /**
     * 'Errors' category for MRTG data and graphs
     */
    const CATEGORY_ERRORS   = 'errs';

    /**
     * 'Discards' category for MRTG data and graphs
     */
    const CATEGORY_DISCARDS = 'discs';

    /**
     * Array of valid categories for graphs
     */
    public static $CATEGORIES = array(
        'Bits'     => INEX_Mrtg::CATEGORY_BITS,
        'Packets'  => INEX_Mrtg::CATEGORY_PACKETS,
        'Errors'   => INEX_Mrtg::CATEGORY_ERRORS,
        'Discards' => INEX_Mrtg::CATEGORY_DISCARDS
    );

    /**
     * Array of valid categories for aggregate graphs
     */
    public static $CATEGORIES_AGGREGATE = array(
        'Bits'     => INEX_Mrtg::CATEGORY_BITS,
        'Packets'  => INEX_Mrtg::CATEGORY_PACKETS
    );


    /**
     * Class constructor.
     *
     * @param $file The MRTG log file to load for analysis
     */
    function __construct( $file = null )
    {
        $this->file = $file;
        $this->loadmrtgfile();
    }


    /**
     * Returns the full absolute path to an MRTG graphing file.
     *
     * This function will sanitise and correct with defaults and inappropriate
     * values for $monitorindex, $category, and $period. $shortname is not sanitised
     * and it is expected that you have already done this.
     *
     * @param $mrtgPath The base path on the filesystem to the MRTG files.
     * @param $type The file type to return. options are 'PNG' for an image file, 'LOG' for an MRTG log file.
     * @param $monitorindex Integer representing the interface number or 'aggregate'.
     * @param $category A value from INEX_Mrtg::$CATEGORIES
     * @param $shortname The customer's shortname
     * @param $period A value from INEX_Mrtg::$PERIODS
     * @return string The full absolute path and filename
     */
    static function getMrtgFilePath( $mrtgPath,
            $type = 'PNG',
            $monitorindex = 'aggregate',
            $category = 'bits',
            $shortname,
            $period = 'day'
        )
    {
        // sanitise these things carefully
        if( is_numeric( $monitorindex ) && $monitorindex > 10 )
            $monitorindex = '1';

        if( !is_numeric( $monitorindex ) && $monitorindex != 'aggregate' )
            $monitorindex = 'aggregate';

        if( !in_array( $period, INEX_Mrtg::$PERIODS ) )
            $period = INEX_Mrtg::$PERIODS['Day'];

        if( !in_array( $category, INEX_Mrtg::$CATEGORIES ) )
            $category = INEX_Mrtg::$CATEGORIES['Bits'];

        $memberdir = $mrtgPath . '/' . $shortname;

        switch( $type )
        {
            case 'PNG':
	            return $memberdir . '/'
                    . $shortname .'-'.$monitorindex .'-'.$category.'-'. $period .'.png';
                break;

            case 'LOG':
                return $memberdir . '/'
                    . $shortname .'-'.$monitorindex .'-'.$category . '.log';
                break;

            default:
                return '';
        }
    }

    /**
     * Utility function to generate URLs for grabbing graph images.
     *
     * FIXME This isn't the right place for this but I'm not sure what is
     *       right now.
     *
     * @param array $params Array of parameters to make up the URL
     * @return string The URL
     */
    public static function generateZendFrontendUrl( $params )
    {
        $url = Zend_Controller_Front::getInstance()->getBaseUrl()
            . '/mrtg/retrieve-image';

        if( isset( $params['shortname'] ) )
            $url .= "/shortname/{$params['shortname']}";

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

        if( isset( $params['graph'] ) )
            $url .= "/graph/{$params['graph']}";

        return $url;
    }

    function getPeriod( $period )
    {
        if( isset( INEX_Mrtg::$PERIOD_TIME[ $period ] ) )
            return INEX_Mrtg::$PERIOD_TIME[ $period ];
        else
            return null;
    }

    /**
     * Scale function
     *
     * This function will scale a number to (for example for traffic
     * measured in bits/second) to Kbps, Mbps, Gbps or Tbps.
     *
     * Valid string formats ($strFormats) and what they return are:
     *    bytes               => Bytes, KBytes, MBytes, GBytes, TBytes
     *    pkts / errs / discs => pps, Kpps, Mpps, Gpps, Tpps
     *    bits / *            => bits, Kbits, Mbits, Gbits, Tbits
     *
     * Valid return types ($intReturn) are:
     *    0 => fully formatted and scaled value. E.g.  12,354.235 Tbits
     *    1 => scaled value without string. E.g. 12,354.235
     *    2 => just the string. E.g. Tbits
     *
     * @param $intNumber The integer value to scale
     * @param $strFormat The string format to use. Valid values are listed above. Defaults to 'bits'.
     * @param $intDem Number of decimals after the decimal point. Defaults to 3.
     * @param $intReturn Type of string to return. Valid values are listed above. Defaults to 0.
     * @return string Scaled / formatted number / type.
     */
    public static function scale( $intNumber, $strFormat = 'bits', $intDem = 3, $intReturn = 0 )
    {
        if( $strFormat == "bytes" )
        {
            $arrFormat = array(
                "Bytes", "KBytes", "MBytes", "GBytes", "TBytes"
            );
        }
        else if( in_array( $strFormat, array( 'pkts', 'errs', 'discs' ) ) )
        {
            $arrFormat = array(
                "pps", "Kpps", "Mpps", "Gpps", "Tpps"
            );
        }
        else
        {
            $intNumber = $intNumber * 8;
            $arrFormat = array(
                "bits", "Kbits", "Mbits", "Gbits", "Tbits"
            );
        }

        for( $i = 0; $i < sizeof( $arrFormat ); $i++ )
        {
            if( ( $intNumber / 1000 < 1 ) || ( sizeof( $arrFormat ) == $i + 1 ) )
            {
                if( !$intReturn )
                    return number_format( $intNumber, $intDem ) . " $arrFormat[$i]";
                elseif( $intReturn == 1 )
                    return number_format( $intNumber, $intDem );
                elseif( $intReturn == 2 )
                    return "$arrFormat[$i]";
                break;
            }
            else
            {
                $intNumber = $intNumber / 1000;
            }
        }
    }


    function loadmrtgfile()
    {
        # Create the array and define other expressions i want to use
        $arrValues = array();

        // Log files are available over HTTP from the monitoring server but
        // are sometimes unavailable during a log update / rebuild / etc.
        // As such, try a reasonable number of times for this infrequent
        // occurance to get a good chance of getting the file.
        for( $i = 0; $i <10; $i++ )
        {
            if( $fd = @fopen( $this->file, "r" ) )
                break;

            sleep( 2 );
        }

        if( !$fd )
        {
            $this->array = array();
            return;
        }


        # Take the values inside the time frame and load them into the array
        $intCounter = 0;
        while( !feof( $fd ) )
        {
            $strLina = fgets( $fd, 4096 );
            $arrLine = explode( " ", $strLina );

            // need to convert $arrLine[4] from string to float,
            // because it contains a trailing <cr>
            if( isset( $arrLine[4] ) )
                $arrLine[ 4 ] = floor( $arrLine[ 4 ] );
            else
                $arrLine[ 4 ] = 0;

            if( $arrLine[ 0 ] ) {
                $arrValues[ $intCounter ] = array(
                    $arrLine[ 0 ],
                    $arrLine[ 1 ],
                    $arrLine[ 2 ],
                    isset( $arrLine[ 3 ] ) ? $arrLine[ 3 ] : 0,
                    isset( $arrLine[ 4 ] ) ? $arrLine[ 4 ] : 0
                );
                $intCounter++;
            }
        }

        fclose( $fd );

        $this->array = $arrValues;
    }

    function getValues( $period = null, $category = 'bits', $doScale = true )
    {
        $periodsecs = $this->getPeriod( $period );

        if( !isset( $periodsecs ) )
            return null;

        $starttime = time() - $periodsecs;
        $endtime = time();

        $maxIn = 0;
        $maxOut = 0;
        $totalIn = 0;
        $totalOut = 0;
        $intLastTime = 0;
        $intTime = 0;

        $gotrealstartdate = false;
        $curenddate = false;

        $arrValues = $this->array;

        # Run through the array and start calculating
        for( $i = sizeof( $arrValues ) - 1; $i > 0; $i-- ) {
            # *** get start and end time
            if( ($arrValues[ $i ][ 0 ] < $starttime) || ($arrValues[ $i ][ 0 ] > $endtime) ) {
                continue;
            }

            $curenddate = $arrValues[ $i ][ 0 ];

            # we depend on array index monotonically increasing
            if( !$gotrealstartdate && $arrValues[ $i ][ 0 ] ) {
                $starttime = $arrValues[ $i ][ 0 ];
                $gotrealstartdate = true;
            }

            list( $intTime, $avgratein, $avgrateout, $peakratein, $peakrateout ) = $arrValues[ $i ];

            if( $peakratein > $maxIn ) {
                $maxIn = $peakratein;
            }
            if( $peakrateout > $maxOut ) {
                $maxOut = $peakrateout;
            }

            if( $intLastTime == 0 ) {
                $intLastTime = $intTime;
            }
            else {
                $intRange = $intTime - $intLastTime;
                $totalIn += $intRange * $avgratein;
                $totalOut += $intRange * $avgrateout;
                $intLastTime = $intTime;
            }
        }

        $endtime = $curenddate;
        $totalTime = $endtime - $starttime;

        $curIn  = isset( $avgratein )  ? $avgratein  : 0.0;
        $curOut = isset( $avgrateout ) ? $avgrateout : 0.0;

        // we use floor() to convert all values to float and round them suitably
        return(
            array(
                'totalin'    => $totalIn,
                'totalout'   => $totalOut,
                'curin'      => $doScale ? $this->scale( $curIn,  $category, 3, 0 ) : $curIn,
                'curout'     => $doScale ? $this->scale( $curOut, $category, 3, 0 ) : $curOut,
                'averagein'  => $doScale ? $this->scale( $totalIn / $totalTime, $category, 3, 0 )  : $totalIn / $totalTime,
                'averageout' => $doScale ? $this->scale( $totalOut / $totalTime, $category, 3, 0 ) : $totalOut / $totalTime,
                'maxin'      => $doScale ? $this->scale( $maxIn, $category, 3, 0 )  : $maxIn,
                'maxout'     => $doScale ? $this->scale( $maxOut, $category, 3, 0 ) : $maxOut
            )
        );
    }

    /**
     * Accessor method for $array - the data from the MRTG file.
     *
     * @return array The data from the MRTG file
     */
    public function getArray()
    {
        return $this->array;
    }

}

