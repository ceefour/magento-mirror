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
class Intik_Indonesiakurir_Block_Adminhtml_Indonesiakurir_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('indonesiakurir_form', array('legend'=>Mage::helper('indonesiakurir')->__('Destination information')));
     
      $fieldset->addField('destination', 'text', array(
          'label'     => Mage::helper('indonesiakurir')->__('Destination City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'destination',
      ));

      $fieldset->addField('service_name', 'select', array(
          'label'     => Mage::helper('indonesiakurir')->__('Service'),
          'name'      => 'service_name',
		  'class'     => 'required-entry',
          'values'    => array(
              array(
                  'value'     => 'REG',
                  'label'     => Mage::helper('indonesiakurir')->__('Regular'),
              ),

              array(
                  'value'     => 'ONS',
                  'label'     => Mage::helper('indonesiakurir')->__('One Night Service'),
              ),
			  
			  array(
                  'value'     => 'SDS',
                  'label'     => Mage::helper('indonesiakurir')->__('Same Day Service'),
              ),
          ),
      ));
     
      $fieldset->addField('rate1', 'text', array(
          'label'     => Mage::helper('indonesiakurir')->__('First Kg Rate'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'rate1',
      ));
	  
	  $fieldset->addField('rate2', 'text', array(
          'label'     => Mage::helper('indonesiakurir')->__('After 1 Kg Rate'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'rate2',
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getIndonesiakurirData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getIndonesiakurirData());
          Mage::getSingleton('adminhtml/session')->setIndonesiakurirData(null);
      } elseif ( Mage::registry('indonesiakurir_data') ) {
          $form->setValues(Mage::registry('indonesiakurir_data')->getData());
      }
      return parent::_prepareForm();
  }
}