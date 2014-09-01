SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema merakli
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `merakli` DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci ;
USE `merakli` ;

-- -----------------------------------------------------
-- Table `merakli`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `merakli`.`categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_turkish_ci' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_turkish_ci;


-- -----------------------------------------------------
-- Table `merakli`.`files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `merakli`.`files` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `filename` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_turkish_ci' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_turkish_ci;


-- -----------------------------------------------------
-- Table `merakli`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `merakli`.`posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_turkish_ci' NOT NULL,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_turkish_ci' NULL DEFAULT NULL,
  `category_id` INT(11) NOT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `category_id_idx` (`category_id` ASC),
  CONSTRAINT `category_id`
    FOREIGN KEY (`category_id`)
    REFERENCES `merakli`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_turkish_ci;


-- -----------------------------------------------------
-- Table `merakli`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `merakli`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `merakli`.`settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `merakli`.`settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `copyright` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
