<?php

/**
 * BasePhysicalinterfaceSeq
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BasePhysicalinterfaceSeq extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('physicalinterface_seq');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}