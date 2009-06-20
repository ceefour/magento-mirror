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
class Intik_Indonesiakurir_Block_Adminhtml_Servicename extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_servicename';
    $this->_blockGroup = 'indonesiakurir';
    $this->_headerText = Mage::helper('indonesiakurir')->__('Indonesia Kurir Service Type Manager');
    $this->_addButtonLabel = Mage::helper('indonesiakurir')->__('Add Service Type');
    parent::__construct();
  }
}