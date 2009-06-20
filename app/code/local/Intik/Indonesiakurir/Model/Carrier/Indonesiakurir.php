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
 * @category   
 * @package    Intik_Indonesiakurir
 * @copyright  Copyright (c) 2008 Int2K (http://www.int2k.web.id)
 * @author     Heri Priyatno
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Intik_Indonesiakurir_Model_Carrier_Indonesiakurir
	extends Mage_Shipping_Model_Carrier_Abstract
	implements Mage_Shipping_Model_Carrier_Interface
{
	/**
	 * unique internal shipping method identifier
	 *
	 * @var string [a-z0-9_]
	 */
	protected $_code = 'indonesiakurir';
	protected $_request = null;
    protected $_result = null;
	
	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
    	// Check if this method is active
		if (!$this->getConfigFlag('active'))
		{
			return false;
		}

// for weight calculation base on volumefield
/*
		$useVolume = ($this->getConfigData('volume_field')!=='');
		$volume_field = $this->getConfigData('volume_field');
		//Mage::log($volume_field);		
		$volume_weight = 0;
		if($useVolume) {

		if ($request->getAllItems()) {
			foreach ($request->getAllItems() as $item) {
               if (!$item->getProduct()->getTypeInstance()->isVirtual()) {
					$product = Mage::getModel('catalog/product')->load( $item->getProductId() );   
					//Mage::log($item->getQty());//_getData('dimension'));//getDimension());
					$product_weight = $product->getWeight();
					$product_volume_weight = $product->_getData($volume_field);
					if ($product_weight >= $product_volume_weight ) {
						$volume_weight += ($product_weight * $item->getQty());
					} else {
						$volume_weight += ($product_volume_weight * $item->getQty());
					}
					Mage::log($volume_weight);
             }
           }
		}
		}		
		
		*/
		// Check if this method is even applicable (must ship from Indonesia)
		
		$origCountry = Mage::getStoreConfig('shipping/origin/country_id', $this->getStore());
		$destCountry = $request->getDestCountryId();

		if (($origCountry != "ID")||($destCountry != "ID")){
			return false;
		} 
		
		//$this->_request = $request;
		$result = Mage::getModel('shipping/rate_result');
		$fromcity = Mage::getStoreConfig('shipping/origin/city', $this->getStore());
		$shipping_methods = Mage::getModel('indonesiakurir/servicename')->getOptionArray(); // get Available Service
		
        $jk = 1;
        foreach($shipping_methods as $shipping_method => $shipping_method_value)
        {	        
			$method = Mage::getModel('shipping/rate_result_method');			
			$request->setServicename($shipping_method);
			$charge = $this->getRate($request);
			$recOK = (!empty($charge));
			if($recOK == "1"){
			    
                $shippingRate = $charge['rate1'] + ( ceil($request->getPackageWeight()-1) * $charge['rate2'] );
		        $shippingPrice = 
				   $request->getBaseCurrency()->convert($shippingRate , $request->getPackageCurrency());

		        $shippingPrice += $this->getConfigData('handling_fee');

	            $method->setCarrier('indonesiakurir');
	            $method->setCarrierTitle($this->getConfigData('title'));

	            $method->setMethod($shipping_method);
	            $method->setMethodTitle($this->getConfigData('title') . " $shipping_method " . $request->getDestCity());
	            $method->setPrice($shippingPrice);
	            $method->setCost($shippingPrice);
	            $result->append($method);
			}
			$jk++;
			
		}

        return $result;
    }
	
	public function getRate(Mage_Shipping_Model_Rate_Request $request)
    {	
        return Mage::getResourceModel('indonesiakurir/carrier_indonesiakurir')->getRate($request);
    }
	
	    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('indonesiakurir' => $this->getConfigData('name'));
    }
	
}

?>