<?php

class Intik_Indonesiakurir_Model_Carrier_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('indonesiakurir')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('indonesiakurir')->__('Disabled')
        );
    }
}