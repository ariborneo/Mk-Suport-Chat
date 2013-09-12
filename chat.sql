SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mksc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mksc` ;

-- -----------------------------------------------------
-- Table `mksc`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mksc`.`user` ;

CREATE  TABLE IF NOT EXISTS `mksc`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `display_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mksc`.`client`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mksc`.`client` ;

CREATE  TABLE IF NOT EXISTS `mksc`.`client` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `last_activity` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mksc`.`chat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mksc`.`chat` ;

CREATE  TABLE IF NOT EXISTS `mksc`.`chat` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `client_id` INT NOT NULL ,
  `user_id` INT NULL ,
  `status` INT NOT NULL DEFAULT 0 ,
  `start_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `end_date` DATETIME NULL ,
  INDEX `fk_chat_users_idx` (`user_id` ASC) ,
  INDEX `fk_chat_clients1_idx` (`client_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_chat_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `mksc`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_chat_clients1`
    FOREIGN KEY (`client_id` )
    REFERENCES `mksc`.`client` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mksc`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mksc`.`message` ;

CREATE  TABLE IF NOT EXISTS `mksc`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `chat_id` INT NOT NULL ,
  `type` INT NOT NULL ,
  `content` VARCHAR(255) NOT NULL ,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_message_chat1_idx` (`chat_id` ASC) ,
  CONSTRAINT `fk_message_chat1`
    FOREIGN KEY (`chat_id` )
    REFERENCES `mksc`.`chat` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mksc` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
