<?php

namespace Jay\Bundle\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user_login' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Jay.Bundle.AdminBundle.Model.map
 */
class UserLoginTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Jay.Bundle.AdminBundle.Model.map.UserLoginTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('user_login');
        $this->setPhpName('UserLogin');
        $this->setClassname('Jay\\Bundle\\AdminBundle\\Model\\UserLogin');
        $this->setPackage('src.Jay.Bundle.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('userlog_id', 'UserlogId', 'INTEGER', true, null, null);
        $this->addForeignKey('userlog_uid', 'UserlogUid', 'INTEGER', 'user', 'user_id', false, null, null);
        $this->addColumn('userlog_date', 'UserlogDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('userlog_ip', 'UserlogIp', 'VARCHAR', false, 40, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'Jay\\Bundle\\AdminBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('userlog_uid' => 'user_id', ), null, null);
    } // buildRelations()

} // UserLoginTableMap
