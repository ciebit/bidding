CREATE TABLE `cb_bidding_persons` ( 
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `type` CHAR(20) NOT NULL ,
    `name` VARCHAR(150) NOT NULL ,
    `document` CHAR(15) NOT NULL ,
    `office` CHAR(100) NULL ,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';