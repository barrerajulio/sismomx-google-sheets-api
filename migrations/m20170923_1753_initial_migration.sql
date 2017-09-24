SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `sismomx_collection_center`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sismomx_collection_center` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `encodedkey` VARCHAR(255) NOT NULL,
  `urgency_level` VARCHAR(10) NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `requirement_details` TEXT NULL,
  `address` VARCHAR(512) NULL,
  `zone` VARCHAR(255) NOT NULL,
  `map` VARCHAR(1024) NULL,
  `more_information` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `encodedkey_UNIQUE` (`encodedkey` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sismomx_help_requests`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sismomx_help_requests` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `encodedkey` VARCHAR(255) NOT NULL,
  `urgency_level` VARCHAR(10) NOT NULL,
  `brigade_required` VARCHAR(2) NOT NULL,
  `most_important_required` TEXT NOT NULL,
  `admitted` TEXT NULL,
  `not_required` TEXT NULL,
  `address` VARCHAR(255) NOT NULL,
  `zone` VARCHAR(255) NOT NULL,
  `source` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `encodedkey_UNIQUE` (`encodedkey` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sismomx_links`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sismomx_links` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `encodedkey` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `encodedkey_UNIQUE` (`encodedkey` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sismomx_shelters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sismomx_shelters` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `encodedkey` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `receiving` TEXT NULL,
  `address` VARCHAR(255) NOT NULL,
  `zone` VARCHAR(255) NOT NULL,
  `map` VARCHAR(1024) NULL,
  `more_information` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `encodedkey_UNIQUE` (`encodedkey` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sismomx_specific_offerings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sismomx_specific_offerings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `encodedkey` VARCHAR(255) NOT NULL,
  `offering_from` VARCHAR(255) NOT NULL,
  `offering_details` TEXT NOT NULL,
  `contact` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `more_information` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `expires_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `encodedkey_UNIQUE` (`encodedkey` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
