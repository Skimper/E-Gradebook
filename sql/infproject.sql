SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


CREATE SCHEMA IF NOT EXISTS `infproject` DEFAULT CHARACTER SET utf8 ;


USE `infproject` ;


CREATE TABLE IF NOT EXISTS `infproject`.`classes` (
  `id` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE IF NOT EXISTS `infproject`.`students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `classes_id` VARCHAR(2) NOT NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `gender` ENUM('male', 'female') NULL,
  `address_street` VARCHAR(45) NULL,
  `address_number` VARCHAR(45) NULL,
  `address_city` VARCHAR(45) NULL,
  `birth_city` VARCHAR(45) NULL,
  `birth_date` DATE NULL,
  `mobile` INT UNSIGNED NULL,
  `mobile_m` INT UNSIGNED NULL,
  `mobile_d` INT UNSIGNED NULL,
  `citizenship` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`teachers` (
  `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `classes_id` VARCHAR(2) NULL,
  `Name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`subject` (
  `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `teachers_id` SMALLINT(3) UNSIGNED NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`teachers_id`)
    REFERENCES `infproject`.`teachers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`grades` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `students_id` INT UNSIGNED NOT NULL,
  `subject_id` SMALLINT(2) UNSIGNED NOT NULL,
  `grade` TINYINT(1) NULL,
  `weight` TINYINT(1) NULL,
  `title` VARCHAR(30) NULL,
  `Description` VARCHAR(60) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`students_id`)
    REFERENCES `infproject`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`subject_id`)
    REFERENCES `infproject`.`subject` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`homework` (
  `id` SMALLINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` SMALLINT(2) UNSIGNED NOT NULL,
  `classes_id` VARCHAR(2) NOT NULL,
  `description` TEXT NULL,
  `topic` TEXT NULL,
  `date` DATE NULL,
  `from` DATE NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`subject_id`)
    REFERENCES `infproject`.`subject` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`exams` (
  `id` SMALLINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` SMALLINT(2) UNSIGNED NOT NULL,
  `classes_id` VARCHAR(2) NOT NULL,
  `topic` TEXT NULL,
  `description` TEXT NULL,
  `date` DATE NULL,
  `from` DATE NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`subject_id`)
    REFERENCES `infproject`.`subject` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`meetings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `classes_id` VARCHAR(2) NOT NULL,
  `topic` TEXT NULL,
  `description` TEXT NULL,
  `date` DATE NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`trips` (
  `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `classes_id` VARCHAR(2) NOT NULL,
  `topic` TEXT NULL,
  `description` TEXT NULL,
  `date` DATE NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`comments` (
  `id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `teachers_id` SMALLINT(3) UNSIGNED NOT NULL,
  `students_id` INT UNSIGNED NOT NULL,
  `type` ENUM('comment', 'praise') NULL,
  `topic` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`teachers_id`)
    REFERENCES `infproject`.`teachers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`students_id`)
    REFERENCES `infproject`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`attendance` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `students_id` INT UNSIGNED NOT NULL,
  `type` TINYINT(1) NULL,
  `day` DATE NULL,
  `lessons` INT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`students_id`)
    REFERENCES `infproject`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`schools` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` TEXT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `infproject`.`topics` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `classes_id` VARCHAR(2) NOT NULL,
  `subject_id` SMALLINT(2) UNSIGNED NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`subject_id`)
    REFERENCES `infproject`.`subject` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `infproject`.`users_students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `students_id` INT UNSIGNED NOT NULL,
  `schools_id` INT UNSIGNED NOT NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(64) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`students_id`)
    REFERENCES `infproject`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`schools_id`)
    REFERENCES `infproject`.`schools` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `infproject`.`users_teachers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `teachers_id` SMALLINT(3) UNSIGNED NOT NULL,
  `schools_id` INT UNSIGNED NOT NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(64) NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`teachers_id`)
    REFERENCES `infproject`.`teachers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`schools_id`)
    REFERENCES `infproject`.`schools` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `infproject`.`timetable` (
  `id` INT NOT NULL,
  `classes_id` VARCHAR(2) NOT NULL,
  `leason` TINYINT(1) NOT NULL,
  `subject_id` SMALLINT(2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`classes_id`)
    REFERENCES `infproject`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

    FOREIGN KEY (`subject_id`)
    REFERENCES `infproject`.`subject` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;