SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `diovax` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `diovax` ;

-- -----------------------------------------------------
-- Table `diovax`.`property`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`property` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `unitcode` VARCHAR(45) NULL ,
  `name` VARCHAR(45) NULL ,
  `title` VARCHAR(45) NULL ,
  `url` VARCHAR(45) NULL ,
  `token` VARCHAR(125) NULL ,
  `description` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `approved` TINYINT(1)  NULL ,
  `leased` TINYINT(1)  NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`expense`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`expense` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `property_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  `amount` FLOAT(10,2) NULL ,
  `doneby` VARCHAR(125) NULL ,
  PRIMARY KEY (`id`, `property_id`) ,
  INDEX `fk_spending_property` (`property_id` ASC) ,
  CONSTRAINT `fk_spending_property`
    FOREIGN KEY (`property_id` )
    REFERENCES `diovax`.`property` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(254) NULL ,
  `email` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `approved` TINYINT(1)  NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`auth`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`auth` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `users_id` INT NOT NULL ,
  `password` VARCHAR(45) NULL ,
  `type` ENUM('password','openid') NULL ,
  `connected` TIMESTAMP NULL ,
  `disconnected` TIMESTAMP NULL ,
  `ip` VARCHAR(45) NULL ,
  `country` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`, `users_id`) ,
  INDEX `fk_auth_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_auth_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `diovax`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`landlord`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`landlord` (
  `users_id` INT NOT NULL ,
  `property_id` INT NOT NULL ,
  PRIMARY KEY (`users_id`, `property_id`) ,
  INDEX `fk_users_has_property_property1` (`property_id` ASC) ,
  INDEX `fk_users_has_property_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_users_has_property_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `diovax`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_property_property1`
    FOREIGN KEY (`property_id` )
    REFERENCES `diovax`.`property` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`media`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`media` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  `url` TEXT NULL ,
  `owner` VARCHAR(125) NULL ,
  `displayed` TINYINT(1)  NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`address`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`address` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `owner` VARCHAR(125) NULL ,
  `line_one` VARCHAR(45) NULL ,
  `line_two` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `country` VARCHAR(45) NULL ,
  `prs` VARCHAR(45) NULL ,
  `latitude` FLOAT(10,6) NULL ,
  `longitude` FLOAT(10,6) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `diovax`.`lease`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `diovax`.`lease` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `property_id` INT NOT NULL ,
  `start` DATETIME NULL ,
  `ends` DATETIME NULL ,
  `started` TINYINT(1)  NULL ,
  `owner` VARCHAR(125) NULL ,
  PRIMARY KEY (`id`, `property_id`) ,
  INDEX `fk_lease_property1` (`property_id` ASC) ,
  CONSTRAINT `fk_lease_property1`
    FOREIGN KEY (`property_id` )
    REFERENCES `diovax`.`property` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
