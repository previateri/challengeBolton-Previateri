-- -----------------------------------------------------
-- Schema curso_son_project_manager
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `challenge_bolton_previateri` DEFAULT CHARACTER SET utf8 ;
USE `challenge_bolton_previateri` ;


CREATE TABLE `nfe_arquivei` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `access_key` varchar(255) DEFAULT NULL,
  `xml_value` longtext CHARACTER SET utf8,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `requests_history` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `status_code` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `page_next` varchar(255) DEFAULT NULL,
  `page_previous` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
