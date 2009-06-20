<?php
class Alcyonis_Referral_IndexController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirectUrl(Mage::helper('customer')->getLoginUrl());
        }

        return $this;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $session         = Mage::getSingleton('core/session');
            $email           = (string) $this->getRequest()->getPost('email');
            $customerSession = Mage::getSingleton('customer/session');
            try {
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    Mage::throwException($this->__('Please enter a valid email address'));
                }
                $referralModel = Mage::getModel('referral/referral');
                if ($referralModel->isSubscribed($email)) {
                    Mage::throwException($this->__('This email has been already submitted'));
                } else {
                    if ($referralModel->subscribe($customerSession->getCustomer(), $email)) {
                        $session->addSuccess($this->__('This email was successfully invited'));
                    }
                }
            }
            catch (Mage_Core_Exception $e) {
                $session->addException($e, $this->__('%s', $e->getMessage()));
            }
            catch (Exception $e) {
                $session->addException($e, $this->__('There was a problem with the invitation'));
            }
        }

        $this->loadLayout();
        $this->renderLayout();
    }
}