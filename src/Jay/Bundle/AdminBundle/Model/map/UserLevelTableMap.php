<?php

namespace Jay\Bundle\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user_level' table.
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
class UserLevelTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Jay.Bundle.AdminBundle.Model.map.UserLevelTableMap';

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
        $this->setName('user_level');
        $this->setPhpName('UserLevel');
        $this->setClassname('Jay\\Bundle\\AdminBundle\\Model\\UserLevel');
        $this->setPackage('src.Jay.Bundle.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ul_id', 'UlId', 'INTEGER', true, null, null);
        $this->addColumn('ul_role', 'UlRole', 'VARCHAR', false, 20, null);
        $this->addColumn('ul_name', 'UlName', 'VARCHAR', false, 40, null);
        $this->addColumn('ul_status', 'UlStatus', 'VARCHAR', false, 10, null);
        $this->addColumn('ul_added_by', 'UlAddedBy', 'INTEGER', false, null, null);
        $this->addColumn('ul_date_added', 'UlDateAdded', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'Jay\\Bundle\\AdminBundle\\Model\\User', RelationMap::ONE_TO_MANY, array('ul_role' => 'user_role', ), null, null, 'Users');
    } // buildRelations()

} // UserLevelTableMap
