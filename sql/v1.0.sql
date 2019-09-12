CREATE TABLE `cb_bidding_persons` ( 
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `type` CHAR(20) NOT NULL ,
    `name` VARCHAR(150) NOT NULL ,
    `document` CHAR(15) NOT NULL ,
    `office` CHAR(100) NULL ,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';

CREATE TABLE `cb_bidding_organs` ( 
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(150) NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';

CREATE TABLE `cb_bidding_publications` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `bidding_id` INT(5) UNSIGNED NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `description` TEXT NULL,
    `file_id` INT(5) UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';