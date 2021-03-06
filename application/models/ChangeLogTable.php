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
 * ChangeLogTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
/**
 *
 * Auto-generated Doctrine ORM File
 *
 * @category ORM
 * @package IXP_ORM_Models
 * @copyright Copyright 2008 - 2010 Internet Neutral Exchange Association Limited <info (at) inex.ie>
 * @author Barry O'Donovan <barryo (at) inex.ie>
 */
class ChangeLogTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ChangeLogTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ChangeLog');
    }


    /**
     * Get updates for a user from a given date
     *
     * @param $priv int The privilege level to check for (and lesser privileges)
     * @param $dateFrom string The date and time (YYYY-MM-DD HH:MM:SS) from when to search the change log or false to indicate 'from the start'
     * @param $hydrateMethod int The Doctrine hydration method (defaults to HYDRATE_RECORD)
     * @return array An array of associate records or Doctrine objects
     */
    public static function getUpdates( $priv = 0, $dateFrom = false, $hydrateMethod = Doctrine_Core::HYDRATE_RECORD )
    {
        $entries = Doctrine_Query::create()
            ->select( 'cl.*' )
            ->addSelect( 'u.username' )
            ->from( 'ChangeLog cl' )
            ->leftJoin( 'cl.User u' )
            ->where( 'cl.visibility <= ?', $priv )
            ->orderBy( 'cl.livedate DESC' );

        if( $dateFrom !== false )
            $entries->andWhere( 'cl.created_at >= ?', $dateFrom );

        return $entries->execute( null, $hydrateMethod );
    }

    /**
     * Does the given user have unseen updates on the change log?
     *
     * @param $priv int The privilege level to check for (and lesser privileges)
     * @param $dateFrom string The date and time (YYYY-MM-DD HH:MM:SS) from when to search the change log or false to indicate 'from the start'
     * @return int The number of entries available (0 can be used to evalaute as false, >0 for true)
     */
    public static function hasUpdates( $priv = 0, $dateFrom = false )
    {
        $count = Doctrine_Query::create()
            ->select( 'COUNT(cl.id)' )
            ->from( 'ChangeLog cl' )
            ->where( 'cl.visibility <= ?', $priv );

        if( $dateFrom !== false )
            $count->andWhere( 'cl.created_at >= ?', $dateFrom );

        return $count->fetchOne( null, Doctrine_Core::HYDRATE_SINGLE_SCALAR );
    }
}
