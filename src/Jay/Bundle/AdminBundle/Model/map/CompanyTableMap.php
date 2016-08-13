<?php

namespace Jay\Bundle\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'company' table.
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
class CompanyTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Jay.Bundle.AdminBundle.Model.map.CompanyTableMap';

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
        $this->setName('company');
        $this->setPhpName('Company');
        $this->setClassname('Jay\\Bundle\\AdminBundle\\Model\\Company');
        $this->setPackage('src.Jay.Bundle.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('company_id', 'CompanyId', 'INTEGER', true, null, null);
        $this->addColumn('company_key', 'CompanyKey', 'VARCHAR', false, 40, null);
        $this->addColumn('company_name', 'CompanyName', 'VARCHAR', false, 100, null);
        $this->addColumn('company_email', 'CompanyEmail', 'VARCHAR', false, 200, null);
        $this->addColumn('company_address', 'CompanyAddress', 'VARCHAR', false, 500, null);
        $this->addColumn('company_status', 'CompanyStatus', 'VARCHAR', false, 10, null);
        $this->addColumn('company_added_by', 'CompanyAddedBy', 'INTEGER', false, null, null);
        $this->addColumn('company_date_added', 'CompanyDateAdded', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'Jay\\Bundle\\AdminBundle\\Model\\User', RelationMap::ONE_TO_MANY, array('company_key' => 'user_company_key', ), null, null, 'Users');
    } // buildRelations()

} // CompanyTableMap
