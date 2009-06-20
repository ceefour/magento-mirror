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
class Intik_Indonesiakurir_Model_Servicename extends Varien_Object
{
    const REGULAR			= 'REG';
    const ONEDAYSERVICE		= 'ONS';
	const SAMEDAYSERVICE	= 'SDS';
	
	protected function _construct()
    {
        //$this->_init('indonesiakurir/servicename');
    }

    static public function getOptionArray()
    {
        return array(
            self::REGULAR    		=> Mage::helper('indonesiakurir')->__('Regular'),
            self::ONEDAYSERVICE   	=> Mage::helper('indonesiakurir')->__('One Night Service'),
			self::SAMEDAYSERVICE  	=> Mage::helper('indonesiakurir')->__('Same Day Service')
        );
    }
}