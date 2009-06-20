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
class Intik_Indonesiakurir_Block_Adminhtml_Servicename_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('servicenameGrid');
      $this->setDefaultSort('servicename_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('indonesiakurir/indonesiakurir')->getCollection();
      $this->setCollection($collection);
		//$debugs = var_export($this,true);
		//die($debugs);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('indonesiakurir_id', array(
          'header'    => Mage::helper('indonesiakurir')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'indonesiakurir_id',
      ));

		$this->addColumn('destination', array(
		  'header'    => Mage::helper('indonesiakurir')->__('Destination City'),
		  'align'     =>'left',
		  'index'     => 'destination',
		));
	  
		$this->addColumn('rate1', array(
          'header'    => Mage::helper('indonesiakurir')->__('First 1 Kg Rate'),
          'align'     =>'right',
          'index'     => 'rate1',
		));
		
		$this->addColumn('rate2', array(
          'header'    => Mage::helper('indonesiakurir')->__('After 1 Kg Rate'),
          'align'     =>'right',
          'index'     => 'rate2',
		));
		
		$this->addColumn('service_name', array(
          'header'    => Mage::helper('indonesiakurir')->__('Service'),
          'align'     =>'left',
          'index'     => 'service_name',
          'width'     => '80px',
          'type'      => 'options',
          'options'   => array(
              'REG' => 'Regular',
              'ONS' => 'One Night Service',
			  'SDS' => 'Same Day Service',
          ),
		));

      $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('indonesiakurir')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('indonesiakurir')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('indonesiakurir')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('indonesiakurir')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('indonesiakurir_id');
        $this->getMassactionBlock()->setFormFieldName('indonesiakurir');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('indonesiakurir')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('indonesiakurir')->__('Are you sure?')
        ));

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}