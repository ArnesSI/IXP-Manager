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


class NetworkinfoController extends INEX_Controller_FrontEnd
{
    public function init()
    {
        $this->frontend['defaultOrdering'] = 'vlanid';
        $this->frontend['model']           = 'Networkinfo';
        $this->frontend['name']            = 'Networkinfo';
        $this->frontend['pageTitle']       = 'Network Info';

        $this->frontend['columns'] = array(

            'displayColumns' => array( 'id', 'vlanid', 'protocol', 'network', 'masklen' ),

            'viewPanelRows'  => array( 'vlanid', 'protocol', 'network', 'masklen', 'rs1address', 'rs2address', 'dnsfile' ),

            'viewPanelTitle' => 'network',

            'sortDefaults' => array(
                'column' => 'vlanid',
                'order'  => 'desc'
            ),

            'id' => array(
                'label' => 'ID',
                'hidden' => true
            ),


            'vlanid' => array(
                'type' => 'hasOne',
                'model' => 'Vlan',
                'controller' => 'vlan',
                'field' => 'name',
                'label' => 'VLAN',
                'sortable' => 'true',
            ),

            'protocol' => array(
                'label' => 'IP Protocol',
                'sortable' => true,
                'type' => 'xlate',
                'xlator' => Networkinfo::$PROTOCOL_TEXT
            ),

            'network' => array(
                'label' => 'Network',
                'sortable' => true
            ),

            'masklen' => array(
                'label' => 'Mask',
                'sortable' => true
            ),

            'rs1address' => array(
                'label' => 'Primary Route Server Address',
                'sortable' => true
            ),

            'rs2address' => array(
                'label' => 'Secondary Route Server Address',
                'sortable' => true
            ),

            'dnsfile' => array(
                'label' => 'DNS Zone File',
                'sortable' => false
            )

        );

        parent::feInit();
    }

}

?>
