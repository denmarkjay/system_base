<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1469866762.
 * Generated on 2016-07-30 10:19:22 
 */
class PropelMigration_1469866762
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

ALTER TABLE `user` CHANGE `birth_date` `user_birth_date` DATE;

ALTER TABLE `user_level` DROP PRIMARY KEY;

ALTER TABLE `user_level` CHANGE `user_level_id` `ul_id` INTEGER NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_level` CHANGE `user_level_name` `ul_name` VARCHAR(40);

ALTER TABLE `user_level` CHANGE `user_level_status` `ul_name` VARCHAR(40);

ALTER TABLE `user_level` CHANGE `user_level_added_by` `ul_added_by` INTEGER;

ALTER TABLE `user_level`
    ADD `ul_status` VARCHAR(40) AFTER `ul_name`;

ALTER TABLE `user_level` ADD PRIMARY KEY (`ul_id`);

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

ALTER TABLE `user` CHANGE `user_birth_date` `birth_date` DATE;

ALTER TABLE `user_level` DROP PRIMARY KEY;

ALTER TABLE `user_level` CHANGE `ul_id` `user_level_id` INTEGER NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_level` CHANGE `ul_name` `user_level_name` VARCHAR(40);

ALTER TABLE `user_level` CHANGE `ul_name` `user_level_status` VARCHAR(40);

ALTER TABLE `user_level` CHANGE `ul_added_by` `user_level_added_by` INTEGER;

ALTER TABLE `user_level` DROP `ul_status`;

ALTER TABLE `user_level` ADD PRIMARY KEY (`user_level_id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}