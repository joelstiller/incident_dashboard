-- MySQL Script generated by MySQL Workbench
-- Wed Jan 19 17:39:12 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema incident_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `incident_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `incident_db` ;

-- -----------------------------------------------------
-- Table `incident_db`.`businessUpdates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `incident_db`.`businessUpdates` ;

CREATE TABLE IF NOT EXISTS `incident_db`.`businessUpdates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parentIncident` VARCHAR(255) NOT NULL,
  `note` VARCHAR(5000) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `incident_db`.`impactedApps`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `incident_db`.`impactedApps` ;

CREATE TABLE IF NOT EXISTS `incident_db`.`impactedApps` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parentIncident` VARCHAR(25) NOT NULL,
  `appName` VARCHAR(255) NOT NULL,
  `details` VARCHAR(2000) NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `incident_db`.`incidents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `incident_db`.`incidents` ;

CREATE TABLE IF NOT EXISTS `incident_db`.`incidents` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `snowTicket` VARCHAR(25) NOT NULL,
  `startTime` VARCHAR(25) NOT NULL,
  `endTime` VARCHAR(25) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL,
  `callStatus` VARCHAR(25) NOT NULL,
  `descrip` VARCHAR(255) NOT NULL,
  `priority` VARCHAR(25) NOT NULL,
  `incidentOwner` VARCHAR(25) NOT NULL,
  `bridgeName` VARCHAR(50) NOT NULL,
  `bridgeURL` VARCHAR(350) CHARACTER SET 'utf8mb4' NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `impact` VARCHAR(24) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `snowTicket` (`snowTicket` ASC));


-- -----------------------------------------------------
-- Table `incident_db`.`updates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `incident_db`.`updates` ;

CREATE TABLE IF NOT EXISTS `incident_db`.`updates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parentIncident` VARCHAR(255) NOT NULL,
  `note` VARCHAR(5000) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `incident_db`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `incident_db`.`users` ;

CREATE TABLE IF NOT EXISTS `incident_db`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `displayname` VARCHAR(75) NOT NULL,
  `salt` VARCHAR(35) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memberOf` VARCHAR(25) NOT NULL,
  `cssMode` TINYTEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC));


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
