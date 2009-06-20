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
class Intik_Indonesiakurir_Adminhtml_IndonesiakurirController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('indonesiakurir/rates')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Rates Manager'), Mage::helper('adminhtml')->__('Rate Manager'));

		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
	   // $debugs = var_export(Mage::getModel('indonesiakurir/carrier_indonesiakurir'),true);
		//print_r('<pre>');
		//print_r($this->getRequest()->getParam('id'));
		//die($debugs);
	
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('indonesiakurir/indonesiakurir')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('indonesiakurir_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('indonesiakurir/rates');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Rate Manager'), Mage::helper('adminhtml')->__('Rate Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Rate News'), Mage::helper('adminhtml')->__('Rate News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('indonesiakurir/adminhtml_indonesiakurir_edit'))
				->_addLeft($this->getLayout()->createBlock('indonesiakurir/adminhtml_indonesiakurir_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('indonesiakurir')->__('Rate does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('indonesiakurir/indonesiakurir');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('indonesiakurir')->__('Rate was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('indonesiakurir')->__('Unable to find rate to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('indonesiakurir/indonesiakurir');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Rate was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $indonesiakurirIds = $this->getRequest()->getParam('indonesiakurir');
        if(!is_array($indonesiakurirIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select rate(s)'));
        } else {
            try {
                foreach ($indonesiakurirIds as $indonesiakurirId) {
                    $indonesiakurir = Mage::getModel('indonesiakurir/indonesiakurir')->load($indonesiakurirId);
                    $indonesiakurir->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($indonesiakurirIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $indonesiakurirIds = $this->getRequest()->getParam('indonesiakurir');
        if(!is_array($indonesiakurirIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select rate(s)'));
        } else {
            try {
                foreach ($indonesiakurirIds as $indonesiakurirId) {
                    $indonesiakurir = Mage::getSingleton('indonesiakurir/indonesiakurir')
                        ->load($indonesiakurirId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($indonesiakurirIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'indonesiakurir.csv';
        $content    = $this->getLayout()->createBlock('indonesiakurir/adminhtml_indonesiakurir_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'indonesiakurir.xml';
        $content    = $this->getLayout()->createBlock('indonesiakurir/adminhtml_indonesiakurir_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}