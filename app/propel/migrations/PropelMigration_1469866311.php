<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1469866311.
 * Generated on 2016-07-30 10:11:51 
 */
class PropelMigration_1469866311
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

ALTER TABLE `company` DROP PRIMARY KEY;

ALTER TABLE `company` CHANGE `id` `company_id` INTEGER NOT NULL AUTO_INCREMENT;

ALTER TABLE `company`
    ADD `company_added_by` VARCHAR(40) AFTER `company_date_added`;

ALTER TABLE `company` ADD PRIMARY KEY (`company_id`);

ALTER TABLE `user` DROP PRIMARY KEY;

ALTER TABLE `user` CHANGE `id` `user_id` INTEGER NOT NULL AUTO_INCREMENT;

ALTER TABLE `user` CHANGE `first_name` `user_fname` VARCHAR(50);

ALTER TABLE `user` CHANGE `last_name` `user_fname` VARCHAR(50);

ALTER TABLE `user` CHANGE `email` `user_email` VARCHAR(200);

ALTER TABLE `user` CHANGE `gender` `user_gender` CHAR;

ALTER TABLE `user` CHANGE `birth_date` `user_birth_date` DATE;

ALTER TABLE `user` CHANGE `phone` `user_phone` VARCHAR(100);

ALTER TABLE `user` CHANGE `status` `user_status` VARCHAR(10);

ALTER TABLE `user` CHANGE `date_added` `user_date_added` DATETIME;

ALTER TABLE `user`
    ADD `user_lname` VARCHAR(50) AFTER `user_fname`,
    ADD `user_user_role` INTEGER AFTER `user_company_key`;

ALTER TABLE `user` ADD PRIMARY KEY (`user_id`);

CREATE INDEX `user_FI_2` ON `user` (`user_user_role`);

CREATE TABLE `user_level`
(
    `user_level_id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_level_name` VARCHAR(40),
    `user_level_status` VARCHAR(40),
    `user_level_added_by` VARCHAR(40),
    PRIMARY KEY (`user_level_id`)
) ENGINE=MyISAM;

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

DROP TABLE IF EXISTS `user_level`;

ALTER TABLE `company` DROP PRIMARY KEY;

ALTER TABLE `company` CHANGE `company_id` `id` INTEGER NOT NULL AUTO_INCREMENT;

ALTER TABLE `company` DROP `company_added_by`;

ALTER TABLE `company` ADD PRIMARY KEY (`id`);

ALTER TABLE `user` DROP PRIMARY KEY;

DROP INDEX `user_FI_2` ON `user`;

ALTER TABLE `user` CHANGE `user_id` `id` INTEGER NOT NULL AUTO_INCREMENT;

ALTER TABLE `user` CHANGE `user_fname` `first_name` VARCHAR(50);

ALTER TABLE `user` CHANGE `user_fname` `last_name` VARCHAR(50);

ALTER TABLE `user` CHANGE `user_email` `email` VARCHAR(200);

ALTER TABLE `user` CHANGE `user_gender` `gender` CHAR;

ALTER TABLE `user` CHANGE `user_birth_date` `birth_date` DATE;

ALTER TABLE `user` CHANGE `user_phone` `phone` VARCHAR(100);

ALTER TABLE `user` CHANGE `user_status` `status` VARCHAR(10);

ALTER TABLE `user` CHANGE `user_date_added` `date_added` DATETIME;

ALTER TABLE `user` DROP `user_lname`;

ALTER TABLE `user` DROP `user_user_role`;

ALTER TABLE `user` ADD PRIMARY KEY (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}