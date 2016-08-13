<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1469876408.
 * Generated on 2016-07-30 13:00:08 
 */
class PropelMigration_1469876408
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

ALTER TABLE `user`
    ADD `user_mname` VARCHAR(50) AFTER `user_fname`,
    ADD `user_user` VARCHAR(20) AFTER `user_lname`,
    ADD `user_password` VARCHAR(40) AFTER `user_user`,
    ADD `user_date_lastlogin` DATETIME AFTER `user_date_added`;

CREATE TABLE `user_login`
(
    `userlog_id` INTEGER NOT NULL AUTO_INCREMENT,
    `userlog_uid` INTEGER,
    `userlog_date` DATETIME,
    `userlog_ip` VARCHAR(40),
    PRIMARY KEY (`userlog_id`),
    INDEX `user_login_FI_1` (`userlog_uid`)
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

DROP TABLE IF EXISTS `user_login`;

ALTER TABLE `user` DROP `user_mname`;

ALTER TABLE `user` DROP `user_user`;

ALTER TABLE `user` DROP `user_password`;

ALTER TABLE `user` DROP `user_date_lastlogin`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}