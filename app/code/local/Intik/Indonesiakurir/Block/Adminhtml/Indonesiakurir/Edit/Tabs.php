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
class Intik_Indonesiakurir_Block_Adminhtml_Indonesiakurir_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('indonesiakurir_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('indonesiakurir')->__('Destination information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('indonesiakurir')->__('Rate Information'),
          'title'     => Mage::helper('indonesiakurir')->__('Rate Information'),
          'content'   => $this->getLayout()->createBlock('indonesiakurir/adminhtml_indonesiakurir_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}