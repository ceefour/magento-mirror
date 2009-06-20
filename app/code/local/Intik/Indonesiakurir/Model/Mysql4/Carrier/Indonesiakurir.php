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
class Intik_Indonesiakurir_Model_Mysql4_Carrier_Indonesiakurir 
    extends Mage_Core_Model_Mysql4_Abstract
{

    protected function _construct()
    {
        $this->_init('indonesiakurir/indonesiakurir', 'indonesiakurir_id');
    }

	public function getRate(Mage_Shipping_Model_Rate_Request $request)
    {
		$zendString = new Zend_Filter_StringToUpper();
		
		$read = $this->_getReadAdapter();
        $write = $this->_getWriteAdapter();
	
        $table = Mage::getSingleton('core/resource')->getTableName('indonesiakurir/indonesiakurir');	
		$DestCity = $zendString->filter($request->getDestCity());
        $select = $read->select()->from($table);
        $select->where(
            $read->quoteInto(" (UPPER(destination)=?) ", $DestCity )
        );
		$select->where('website_id=?', $request->getWebsiteId());
		$select->where('service_name=?', $request->getServicename());

        $select->limit(1);

        $row = $read->fetchRow($select);
        return $row;
    }
	
   
	private function _isPositiveDecimalNumber($n)
    {
        return preg_match ("/^[0-9]+(\.[0-9]*)?$/", $n);
    }
}
