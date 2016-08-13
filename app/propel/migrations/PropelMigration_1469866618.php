<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1469866618.
 * Generated on 2016-07-30 10:16:58 
 */
class PropelMigration_1469866618
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

ALTER TABLE `user` CHANGE `email` `user_email` VARCHAR(200);

ALTER TABLE `user` CHANGE `birth_date` `user_birth_date` DATE;

ALTER TABLE `user`
    ADD `user_added_by` INTEGER AFTER `user_user_role`;

ALTER TABLE `user` DROP `last_name`;

ALTER TABLE `user_level` CHANGE `user_level_added_by` `user_level_added_by` INTEGER;

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

ALTER TABLE `user` CHANGE `user_email` `email` VARCHAR(200);

ALTER TABLE `user` CHANGE `user_birth_date` `birth_date` DATE;

ALTER TABLE `user`
    ADD `last_name` VARCHAR(50) AFTER `user_lname`;

ALTER TABLE `user` DROP `user_added_by`;

ALTER TABLE `user_level` CHANGE `user_level_added_by` `user_level_added_by` VARCHAR(40);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}