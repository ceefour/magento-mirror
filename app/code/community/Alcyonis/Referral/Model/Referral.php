<?php

class Alcyonis_Referral_Model_Referral extends Mage_Core_Model_Abstract
{
    const XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE       = 'referral/subscription/email_template';
    const XML_PATH_SUBSCRIPTION_EMAIL_IDENTITY       = 'referral/subscription/email_identity';

    const XML_PATH_CONFIRMATION_EMAIL_TEMPLATE       = 'referral/confirmation/email_template';
    const XML_PATH_CONFIRMATION_EMAIL_IDENTITY       = 'referral/confirmation/email_identity';

    public function _construct()
    {
        parent::_construct();
        $this->_init('referral/referral');
    }

    public function loadByEmail($customerEmail)
    {
        $this->addData($this->getResource()->loadByEmail($customerEmail));
        return $this;
    }

    public function subscribe(Mage_Customer_Model_Customer $father, $email)
    {
        $this->setFatherId($father->getId())
             ->setEmail($email);
        return $this->save() && $this->sendSubscription($father, $email);
    }

    public function isSubscribed($email)
    {
        $collection = $this->getCollection()->addEmailFilter($email);
        return $collection->count() ? true : false;
    }

    public function isConfirmed($email)
    {
        $collection = $this->getCollection()->addFlagFilter(0);
        $collection->addEmailFilter($email);
        return $collection->count() ? false : true;
    }

    public function sendSubscription(Mage_Customer_Model_Customer $father, $destination)
    {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');
        /* @var $email Mage_Core_Model_Email_Template */
        $email->sendTransactional(
            Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE),
            Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_IDENTITY),
            $destination,
            $destination,
            array(
                'father'   => $father,
                'referral' => $this
            )
        );
        return $email->getSentSuccess();
    }

    public function sendConfirmation(Mage_Customer_Model_Customer $father, Mage_Customer_Model_Customer $son, $destination)
    {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');
        /* @var $email Mage_Core_Model_Email_Template */
        $email->sendTransactional(
            Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_EMAIL_TEMPLATE),
            Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_EMAIL_IDENTITY),
            $destination,
            $destination,
            array(
                'father'   => $father,
                'son'   => $son,
                'referral' => $this
            )
        );
        return $email->getSentSuccess();
    }
     
}