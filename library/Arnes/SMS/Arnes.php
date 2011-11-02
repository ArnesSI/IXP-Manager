<?php

/*
 * Copyright (C) 2009-2011 Internet Neutral Exchange Association Limited.
 * All Rights Reserved.
 * 
 * This file is part of IXP Manager. Arnes extension.
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
 * SMS - Short Messaging System
 *
 * A class to send SMS messages via different backends
 *
 * Specific functions for Arnes SMS GW
 *
 * http://www.inex.ie/
 * (c) Copyright 2009 Internet Neutral Exchange Association Ltd
 *
 *
 *  @package Arnes_SMS
 */
class Arnes_SMS_Arnes
{

    /**
     * SMS gateway hosts
     */
    private static $SMS_GW = array( '193.2.1.92', '193.2.18.167' ); // planja,ozebnik

    /**
     * SMS gateway URL
     */
    const URL_SEND_SMS = "http://%s:13013/cgi-bin/sendsms?username=%s&password=%s&to=%s&text=%s";

    /**
     * Arnes SMS GW account username
     */
    private $username;

    /**
     * Arnes SMS GW account password
     */
    private $password;


    /**
     * Last SMS GW we tried to send SMS via
     */
    private $lastGW;

    /**
     * Was something wrong when sendong SMS
     */
    public $isError = false;

    /**
     * Response text
     */
    public $apiResponse;

    /**
     * Response HTTP headers
     */
    public $apiResponseHeaders;


    /**
     * Constructor for the Arnes SMS API.
     *
     * @param $user string The Arnes SMS GW account username
     * @param $pass string The Arnes SMS GW account password
     */
    public function __construct( $user = null, $pass = null )
    {
        if( $user !== null )
            $this->setUsername( $user );

        if( $pass !== null )
            $this->setPassword( $pass );
    }


    /**
     * Set the Arnes SMS GW account password
     *
     * @param $pass string Arnes SMS GW password
     */
    public function setPassword( $pass )
    {
        $this->password = $pass;
    }


    /**
     * Set the Arnes SMS GW account username
     *
     * @param $user string Arnes SMS GW username
     */
    public function setUsername( $user )
    {
        $this->username = $user;
    }


    /**
     * Send an SMS message
     *
     * @param $to string The recipient number in international format (e.g. 353861234567)
     * @param $message string The message to send
     * @return TRUE on successful, else FALSE
     */
    public function send( $to, $message )
    {
        // send only first 160 chars of message
        $message = substr($message, 0, 160);

        foreach (Arnes_SMS_Arnes::$SMS_GW as $sms_host)
        {
            // build the request string
            $apiCall = sprintf( Arnes_SMS_Arnes::URL_SEND_SMS,
                $sms_host, $this->username, $this->password, $to,
                urlencode( $message )
            );

            $this->lastGW = $sms_host;
            $this->apiResponse = @file_get_contents( $apiCall );
            $this->apiResponseHeaders = $http_response_header;

            if( $this->apiResponse === false || strpos($this->apiResponseHeaders[0], ' 200 ') === false )
            {
                $this->isError = true;
            }
            else
            {
                $this->isError = false;
                return true;
            }
        }
        if ($this->isError)
            // for compatibility with INEX IXP-Manager
            $this->apiResponse = $this->apiResponseHeaders[0];
            return false;
    }

    /**
     * Return a string with a detailed error message
     *
     * @return $str string Message containing HTTP API response headers and body
     */
    public function getErrorString() 
    {
        $str = '';

        if ($this->isError === false)
            return $str;

        if ($this->lastGW)
            $str.= "Last SMS GW used: ".$this->lastGW."\n";
        if ($this->apiResponseHeaders)
            $str.= "HTTP Headers: \n".print_r($this->apiResponseHeaders, true);
        if ($this->apiResponse)
            $str.= "HTTP Response: \n".$this->apiResponse;
        return $str;
    }

}

?>
