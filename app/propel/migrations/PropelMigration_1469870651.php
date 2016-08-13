<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1469870651.
 * Generated on 2016-07-30 11:24:11 
 */
class PropelMigration_1469870651
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `company` CHANGE `company_added_by` `company_added_by` INTEGER;

DROP INDEX `user_FI_2` ON `user`;

ALTER TABLE `user` CHANGE `user_user_role` `user_age` INTEGER;

ALTER TABLE `user` CHANGE `user_gender` `user_gender` VARCHAR(6);

ALTER TABLE `user` CHANGE `user_company_key` `user_company_key` VARCHAR(40) NOT NULL;

ALTER TABLE `user`
    ADD `user_role` VARCHAR(20) NOT NULL AFTER `user_company_key`;

CREATE INDEX `user_FI_2` ON `user` (`user_role`);

ALTER TABLE `user_level` CHANGE `ul_status` `ul_status` VARCHAR(10);

ALTER TABLE `user_level`
    ADD `ul_date_added` DATETIME AFTER `ul_added_by`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `company` CHANGE `company_added_by` `company_added_by` VARCHAR(40);

DROP INDEX `user_FI_2` ON `user`;

ALTER TABLE `user` CHANGE `user_age` `user_user_role` INTEGER;

ALTER TABLE `user` CHANGE `user_gender` `user_gender` CHAR;

ALTER TABLE `user` CHANGE `user_company_key` `user_company_key` VARCHAR(40);

ALTER TABLE `user` DROP `user_role`;

CREATE INDEX `user_FI_2` ON `user` (`user_user_role`);

ALTER TABLE `user_level` CHANGE `ul_status` `ul_status` VARCHAR(40);

ALTER TABLE `user_level` DROP `ul_date_added`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}