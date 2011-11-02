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
 *
 * @package INEX_Form
 */
class INEX_Form_Networkinfo extends INEX_Form
{
    /**
     *
     *
     */
    public function __construct( $options = null, $isEdit = false, $cancelLocation )
    {
        parent::__construct( $options, $isEdit );

        ////////////////////////////////////////////////
        // Create and configure elements
        ////////////////////////////////////////////////

        $dbVlans = Doctrine_Query::create()
        ->from( 'Vlan v' )
        ->orderBy( 'v.name ASC' )
        ->execute();
        
        $vlans = array( '0' => '' );
        $maxId = 0;

        foreach( $dbVlans as $v )
        {
            $vlans[ $v['id'] ] = "{$v['name']} ({$v['number']})";
            if( $v['id'] > $maxId ) $maxId = $v['id'];
        }

        $vlan = $this->createElement( 'select', 'vlanid' );
        $vlan->setMultiOptions( $vlans );
        $vlan->setRegisterInArrayValidator( true )
        ->setRequired( true )
        ->setLabel( 'VLAN' )
        ->addValidator( 'between', false, array( 1, $maxId ) )
        ->setErrorMessages( array( 'Please select a VLAN' ) );

        $this->addElement( $vlan );


        $protocol = $this->createElement( 'select', 'protocol' );
        $protocol->setMultiOptions( Networkinfo::$PROTOCOL_TEXT )
                 ->setRegisterInArrayValidator( true )
                 ->setLabel( 'Address Family' )
                 ->setErrorMessages( array( 'Please select address family' ) );

        $this->addElement( $protocol );


        $network = $this->createElement( 'text', 'network' );
        $network->addValidator( 'stringLength', false, array( 1, 255 ) )
        ->setRequired( true )
        ->setLabel( 'Network address' )
        ->addFilter( 'StringTrim' )
        ->addFilter( new INEX_Filter_StripSlashes() );

        $this->addElement( $network );


        $masklen = $this->createElement( 'text', 'masklen' );
        $masklen->addValidator( 'stringLength', false, array( 1, 3 ) )
        ->setRequired( true )
        ->setLabel( 'Network length' )
        ->addFilter( 'StringTrim' )
        ->addFilter( new INEX_Filter_StripSlashes() );

        $this->addElement( $masklen );


        $rs1address = $this->createElement( 'text', 'rs1address' );
        $rs1address->addValidator( 'stringLength', false, array( 1, 255 ) )
        ->setRequired( true )
        ->setLabel( 'Primary Route Server Address' )
        ->addFilter( 'StringTrim' )
        ->addFilter( new INEX_Filter_StripSlashes() );

        $this->addElement( $rs1address );


        $rs2address = $this->createElement( 'text', 'rs2address' );
        $rs2address->addValidator( 'stringLength', false, array( 1, 255 ) )
        ->setRequired( true )
        ->setLabel( 'Secondary Route Server Address' )
        ->addFilter( 'StringTrim' )
        ->addFilter( new INEX_Filter_StripSlashes() );

        $this->addElement( $rs2address );


        $dnsfile = $this->createElement( 'text', 'dnsfile' );
        $dnsfile->addValidator( 'stringLength', false, array( 1, 255 ) )
        ->setRequired( true )
        ->setLabel( 'DNS Zone File' )
        ->addFilter( 'StringTrim' )
        ->addFilter( new INEX_Filter_StripSlashes() );

        $this->addElement( $dnsfile );


        $this->addElement( 'button', 'cancel', array( 'label' => 'Cancel', 'onClick' => "parent.location='"
        . $cancelLocation . "'" ) );
        $this->addElement( 'submit', 'commit', array( 'label' => 'Add' ) );

    }

}

?>
