<?php
class Alcyonis_Referral_Model_Observer
{
    
    public function sales_order_invoice_pay($observer)
    {
        $order = $observer->getEvent()->getInvoice()->getOrder();
        $referralModel = Mage::getModel('referral/referral');
        if ($referralModel->isSubscribed($order->getCustomerEmail())) {
            if (!$referralModel->isConfirmed($order->getCustomerEmail())) {
                $referralModel->loadByEmail($order->getCustomerEmail());
                $referralModel->setData('flag', true);
                $referralModel->setData('son_id', $order->getCustomerId());
                $referralModel->save();

                // Let's send an email to the father to congratz him
                $father = Mage::getModel('customer/customer')->load($referralModel->getData('father_id'));
                $son    = Mage::getModel('customer/customer')->load($referralModel->getData('son_id'));
                $referralModel->sendConfirmation($father, $son, $father->getEmail());
                
                // Here you want to give a bonus to the father because the son ordered something.
                // In our case, a giftcert
                try {

                    $model = Mage::getModel('ugiftcert/cert')
                        ->setId(null)
                        ->setCertNumber(Mage::getStoreConfig('ugiftcert/default/cert_number'))
                        ->setBalance(Mage::getStoreConfig('referral/cert/amount'))
                        ->setCurrencyCode(Mage::app()->getStore()->getDefaultCurrency()->getCurrencyCode())
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setStatus('A')
                        ->setExpireAt()
                        ->setSenderName()
                        ->setPin(Mage::getStoreConfig('ugiftcert/default/pin'));
                    
                    $model->setRecipientName()
                          ->setRecipientEmail($father->getEmail())
                          ->setRecipientAddress('')
                          ->setRecipientMessage('');
    
                    $data = array(
                        'user_id'     => $father->getId(),
                        'username'    => $father->getName(),
                        'ts'          => now(),
                        'amount'      => Mage::getStoreConfig('referral/cert/amount'),
                        'currency_code' => Mage::app()->getStore()->getDefaultCurrency()->getCurrencyCode(),
                        'status'      => 'A',
                        'comments'    => ''
                    );                
                    
                    $num = $model->getCertNumber();
                    if (!Mage::helper('ugiftcert')->isPattern($num)) {
    
                        $dup = Mage::getModel('ugiftcert/cert')->load($num, 'cert_number');
                        if ($dup->getId()) {
                            throw new Exception($this->__('Duplicate Gift Certificate Code was found.'));
                        }
                    }
    
                    $data['action_code'] = 'create';
                    //$data['order_id'] = $order->getId();
                    $data['customer_id'] = $father->getId();
                    $data['customer_email'] = $father->getEmail();

                    $model->save();
                    $model->addHistory($data);
                    $model->setAmount($model->getBalance());
                    Mage::helper('ugiftcert')->sendManualEmail($model);

                } catch (Exception $e) {
                    //Mage::getSingleton('session')->addError($e->getMessage());
                }                           
            }
        }
    }
    
}