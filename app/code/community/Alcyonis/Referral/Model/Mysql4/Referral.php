<?php

class Alcyonis_Referral_Model_Mysql4_Referral extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the referral_id refers to the key field in your database table.
        $this->_init('referral/referral', 'referral_id');
    }   
    
    public function loadByEmail($customerEmail)
    {
        $select = $this->_getReadAdapter()->select()
            ->from('referral')
            ->where('email = ?',$customerEmail);
        $result = $this->_getReadAdapter()->fetchRow($select);
        if(!$result) {
            return array();
        }

        return $result;
    }    
}