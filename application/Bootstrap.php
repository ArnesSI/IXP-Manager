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


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Register the INEX library autoloader
     *
     * This function ensures that classes from library/INEX are automatically
     * loaded from the subdirectories where subdirectories are indicated by
     * underscores in the same manner as Zend.
     *
     */
    protected function _initINEXAutoLoader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace( 'INEX' );
    }


    /**
     * Register the Arnes library autoloader
     *
     * This function ensures that classes from library/Arnes are automatically
     * loaded from the subdirectories where subdirectories are indicated by
     * underscores in the same manner as Zend.
     *
     */
    protected function _initArnesAutoLoader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace( 'Arnes' );
    }

}

