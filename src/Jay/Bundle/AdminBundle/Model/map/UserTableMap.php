<?php

namespace Jay\Bundle\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user' table.
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
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Jay.Bundle.AdminBundle.Model.map.UserTableMap';

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
        $this->setName('user');
        $this->setPhpName('User');
        $this->setClassname('Jay\\Bundle\\AdminBundle\\Model\\User');
        $this->setPackage('src.Jay.Bundle.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('user_id', 'UserId', 'INTEGER', true, null, null);
        $this->addColumn('user_fname', 'UserFname', 'VARCHAR', false, 50, null);
        $this->addColumn('user_mname', 'UserMname', 'VARCHAR', false, 50, null);
        $this->addColumn('user_lname', 'UserLname', 'VARCHAR', false, 50, null);
        $this->addColumn('user_login', 'UserLogin', 'VARCHAR', false, 20, null);
        $this->addColumn('user_password', 'UserPassword', 'VARCHAR', false, 40, null);
        $this->addColumn('user_email', 'UserEmail', 'VARCHAR', false, 200, null);
        $this->addColumn('user_gender', 'UserGender', 'VARCHAR', false, 6, null);
        $this->addColumn('user_birth_date', 'UserBirthDate', 'DATE', false, null, null);
        $this->addColumn('user_age', 'UserAge', 'INTEGER', false, null, null);
        $this->addColumn('user_phone', 'UserPhone', 'VARCHAR', false, 100, null);
        $this->addForeignKey('user_company_key', 'UserCompanyKey', 'VARCHAR', 'company', 'company_key', true, 40, null);
        $this->addForeignKey('user_role', 'UserRole', 'VARCHAR', 'user_level', 'ul_role', true, 20, null);
        $this->addColumn('user_status', 'UserStatus', 'VARCHAR', false, 10, null);
        $this->addColumn('user_added_by', 'UserAddedBy', 'INTEGER', false, null, null);
        $this->addColumn('user_date_added', 'UserDateAdded', 'TIMESTAMP', false, null, null);
        $this->addColumn('user_date_lastlogin', 'UserDateLastlogin', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Company', 'Jay\\Bundle\\AdminBundle\\Model\\Company', RelationMap::MANY_TO_ONE, array('user_company_key' => 'company_key', ), null, null);
        $this->addRelation('UserLevel', 'Jay\\Bundle\\AdminBundle\\Model\\UserLevel', RelationMap::MANY_TO_ONE, array('user_role' => 'ul_role', ), null, null);
        $this->addRelation('UserLogin', 'Jay\\Bundle\\AdminBundle\\Model\\UserLogin', RelationMap::ONE_TO_MANY, array('user_id' => 'userlog_uid', ), null, null, 'UserLogins');
    } // buildRelations()

} // UserTableMap
