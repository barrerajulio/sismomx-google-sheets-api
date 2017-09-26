# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.35)
# Base de datos: sismomx
# Tiempo de Generación: 2017-09-24 22:26:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla sismomx_collection_center
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sismomx_collection_center`;

CREATE TABLE `sismomx_collection_center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoded_key` varchar(255) NOT NULL DEFAULT '',
  `urgency_level` varchar(10) DEFAULT '',
  `location` varchar(255) DEFAULT '',
  `requirements_details` text,
  `address` varchar(512) DEFAULT NULL,
  `zone` varchar(255) DEFAULT '',
  `map` varchar(1024) DEFAULT NULL,
  `geolocation` varchar(255) DEFAULT NULL,
  `more_information` text,
  `contact` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla sismomx_help_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sismomx_help_requests`;

CREATE TABLE `sismomx_help_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoded_key` varchar(255) NOT NULL DEFAULT '',
  `urgency_level` varchar(10) DEFAULT '',
  `brigade_required` text,
  `most_important_required` text,
  `admitted` text,
  `not_required` text,
  `address` varchar(255) DEFAULT '',
  `zone` varchar(255) DEFAULT '',
   `geolocation` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla sismomx_links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sismomx_links`;

CREATE TABLE `sismomx_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoded_key` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `encodedkey_UNIQUE` (`encoded_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla sismomx_shelters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sismomx_shelters`;

CREATE TABLE `sismomx_shelters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoded_key` varchar(255) NOT NULL DEFAULT '',
  `location` varchar(255) NOT NULL,
  `receiving` text,
  `address` varchar(255) NOT NULL,
  `zone` varchar(255) NOT NULL,
  `map` varchar(1024) DEFAULT NULL,
  `geolocation` varchar(255) DEFAULT NULL,
  `more_information` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `encodedkey_UNIQUE` (`encoded_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla sismomx_specific_offerings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sismomx_specific_offerings`;

CREATE TABLE `sismomx_specific_offerings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoded_key` varchar(255) NOT NULL DEFAULT '',
  `offering_from` varchar(255) DEFAULT '',
  `offering_details` text,
  `contact` varchar(255) DEFAULT NULL,
  `notes` text,
  `more_information` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `expires_at` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `encodedkey_UNIQUE` (`encoded_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
