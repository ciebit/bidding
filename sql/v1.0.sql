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


CREATE TABLE `cb_bidding_committees` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `external_id` VARCHAR(100) NULL,
    `name` VARCHAR(200) NOT NULL,
    `date_creation` DATE NOT NULL,
    `manager_id` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';


CREATE TABLE `cb_bidding_committees_members` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `committee_id` INT(5) UNSIGNED NOT NULL,
    `person_id` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';

--
-- Contracts
--
CREATE TABLE `cb_bidding_contracts` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `number` VARCHAR(100) NULL,
    `year_of_exercise` YEAR NOT NULL,
    `bidding_id` INT(5) UNSIGNED NOT NULL,
    `organ_id` INT(5) UNSIGNED NOT NULL,
    `person_id` INT(5) UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    `start_date` DATE NOT NULL,
    `final_date` DATE NOT NULL,
    `global_price` DECIMAL(13,2) UNSIGNED NOT NULL,
    `object_description` TEXT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';

CREATE TABLE `cb_bidding_contracts_files` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `contract_id` INT(5) UNSIGNED NOT NULL,
    `file_id` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';


--
-- Bidding
--
CREATE TABLE `cb_bidding` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `committee_id` INT(5) UNSIGNED NOT NULL,
    `estimate_budget_amount` DECIMAL(13,2) UNSIGNED NOT NULL,
    `modality` TINYINT(1) UNSIGNED NOT NULL,
    `notice_publication_date` DATETIME NOT NULL,
    `number` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(200) NOT NULL,
    `object_description` TEXT NULL,
    `opening_date_time` DATETIME NOT NULL,
    `opening_place_name` VARCHAR(200) NULL,
    `opening_place_address` VARCHAR(255) NULL,
    `opening_place_number` VARCHAR(100) NULL,
    `opening_place_neighborhood` VARCHAR(255) NULL,
    `opening_place_complement` VARCHAR(255) NULL,
    `opening_place_city` VARCHAR(200) NULL,
    `opening_place_state` VARCHAR(200) NULL,
    `opening_place_zipcode` INT(8) NULL,
    `person_ordered_id` INT(5) UNSIGNED NULL,
    `responsible_information_id` INT(5) UNSIGNED NULL,
    `responsible_legal_advice_id` INT(5) UNSIGNED NULL,
    `responsible_award_id` INT(5) UNSIGNED NULL,
    `responsible_approval_id` INT(5) UNSIGNED NULL,
    `status` TINYINT(1) UNSIGNED NOT NULL,
    `type` TINYINT(1) UNSIGNED NOT NULL,
    `upper_limite_value` DECIMAL(13,2) UNSIGNED NOT NULL,
    `year_of_exercise` YEAR NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';

CREATE TABLE `cb_bidding_files` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `bidding_id` INT(5) UNSIGNED NOT NULL,
    `file_id` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';

CREATE TABLE `cb_bidding_organs_association` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `bidding_id` INT(5) UNSIGNED NOT NULL,
    `organ_id` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB COMMENT = 'version:1.0';