
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- company
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `company_key` VARCHAR(40),
    `company_name` VARCHAR(100),
    `company_email` VARCHAR(200),
    `company_address` VARCHAR(500),
    `company_status` VARCHAR(10),
    `company_date_added` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50),
    `last_name` VARCHAR(50),
    `email` VARCHAR(200),
    `gender` CHAR,
    `birth_date` DATE,
    `phone` VARCHAR(100),
    `status` VARCHAR(10),
    `date_added` DATETIME,
    `user_company_key` VARCHAR(40),
    PRIMARY KEY (`id`),
    INDEX `user_FI_1` (`user_company_key`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
