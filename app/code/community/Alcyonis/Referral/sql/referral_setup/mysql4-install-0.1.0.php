<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('referral')};
CREATE TABLE {$this->getTable('referral')} (
  `referral_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `father_id` INTEGER(11) UNSIGNED NOT NULL,
  `son_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL DEFAULT '',
  `flag` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`referral_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `son_id` (`son_id`),
  KEY `FK_customer_entity` (`father_id`),
  CONSTRAINT `referral_father_fk` FOREIGN KEY (`father_id`) REFERENCES `customer_entity` (`entity_id`),
  CONSTRAINT `referral_son_fk1` FOREIGN KEY (`son_id`) REFERENCES `customer_entity` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 