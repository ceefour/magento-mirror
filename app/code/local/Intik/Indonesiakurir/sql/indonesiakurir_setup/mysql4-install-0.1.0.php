<?php
/**
 * Magento Int2K Indonesiakurir Shipping Mdoule
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category   Intik
 * @package    Intik_Indonesiakurir
 * @copyright  Copyright (c) 2008 Int2K (http://www.int2k.web.id)
 * @author     Heri Priyatno
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('indonesiakurir')};
CREATE TABLE {$this->getTable('indonesiakurir')} (
  `indonesiakurir_id` int(11) unsigned NOT NULL auto_increment,
  `website_id` int(11) NOT NULL default '1',
  `status` smallint(6) NOT NULL default '0',
  `destination` varchar(255) NOT NULL default '',
  `rate1` decimal(12,4) NOT NULL default '0.0000',
  `rate2` decimal(12,4) NOT NULL default '0.0000',
  `service_name` varchar(25) NOT NULL default '0',
  PRIMARY KEY  (`indonesiakurir_id`),
  UNIQUE KEY `id_dest_city` (`website_id`,`destination`,`service_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 