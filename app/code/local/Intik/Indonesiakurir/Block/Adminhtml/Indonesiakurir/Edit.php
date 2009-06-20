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
class Intik_Indonesiakurir_Block_Adminhtml_Indonesiakurir_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'indonesiakurir';
        $this->_controller = 'adminhtml_indonesiakurir';
        
        $this->_updateButton('save', 'label', Mage::helper('indonesiakurir')->__('Save City'));
        $this->_updateButton('delete', 'label', Mage::helper('indonesiakurir')->__('Delete City'));
		
        
    }

    public function getHeaderText()
    {	    
        if( Mage::registry('indonesiakurir_data') && Mage::registry('indonesiakurir_data')->getId() ) {
            return Mage::helper('indonesiakurir')->__("Edit City %s - %s", 
					$this->htmlEscape(Mage::registry('indonesiakurir_data')->getDestination()),
					$this->htmlEscape(
						Mage::helper('indonesiakurir')->translatename(
						Mage::registry('indonesiakurir_data')->getService_name())
					)
				);
        } else {
            return Mage::helper('indonesiakurir')->__('Add Destination City');
        }
    }
}