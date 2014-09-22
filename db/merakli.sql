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

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'PHP'),
(2, 'jQuery Nedir?'),
(3, 'SQL'),
(4, 'Diğer');


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

INSERT INTO `posts` (`id`, `title`, `content`, `category_id`, `created`, `updated`) VALUES
(1, 'PHP Nedir?', 'PHP (açılımı PHP: Hypertext Preprocessor) geniş bir kitle tarafından kullanılan, özellikle sanal yöreler üzerinde geliştirme için tasarlanmış HTML içine gömülebilen bir betik dilidir.', 1, '2014-08-18 00:00:00', '2014-08-18 00:00:00'),
(3, 'OOP''ye giriş', 'OOP''yi çok severiz. OOP kullanmamak çok sıkıntı çıkarır, spaghetti insanın midesini bozar.', 1, '2014-08-23 11:46:55', '2014-08-23 13:20:23'),
(5, 'Nesne Yönelimli Programlama nasıl yapılmalı', 'İnce eleyip sık dokuyarak', 1, '2014-08-26 18:53:07', '2014-08-26 18:53:07'),
(6, 'jQuery Nedir?', 'Jquery', 2, '2014-09-21 17:17:42', '2014-09-21 17:17:42');



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

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'username', 'mtkocak@mtkocak.net', '5f4dcc3b5aa765d61d8327deb882cf99');



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

INSERT INTO `settings` (`id`, `title`, `description`, `copyright`) VALUES
(1, 'Merakli Bilişimci', 'Merakli İnternet Mühendisinden meraklılara geliyor', 'Copyright 2014 Meraklibilismci.com');


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
