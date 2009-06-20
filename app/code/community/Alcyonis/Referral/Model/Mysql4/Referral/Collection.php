<?php

class Alcyonis_Referral_Model_Mysql4_Referral_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('referral/referral');
    }
    
    public function addEmailFilter($email)
    {
        $this->getSelect()->where('email = ?', $email);
        return $this;
    }

    public function addFlagFilter($flag)
    {
        $this->getSelect()->where('flag = ?', $flag);
        return $this;
    }     
}