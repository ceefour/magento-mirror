<?php
/**
 * Unirgy_Giftcert extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Unirgy
 * @package    Unirgy_Giftcert
 * @copyright  Copyright (c) 2008 Unirgy LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Unirgy
 * @package    Unirgy_Giftcert
 * @author     Boris (Moshe) Gurevich <moshe@unirgy.com>
 */
class Unirgy_Giftcert_Model_Creditmemo_Total extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $cm)
    {

        $order = $cm->getOrder();

/*echo "<pre>";
print_r($cm->debug());
print_r($order->debug());
exit;*/
        return $this;

        $baseGcAmount = $order->getBaseGiftcertAmount();
        $baseGcCredited = $order->getBaseGiftcertCredited();
        $baseCmTotal = $cm->getBaseGrandTotal();
        $cmTotal = $cm->getGrandTotal();

        if (!$baseGcAmount || $baseGcCredited==$baseGcAmount) {
            return $this;
        }

        $baseGcBalance = $baseGcAmount-$baseGcCredited;

        if ($baseGcBalance >= $baseCmTotal) {
            $baseGcUsed = $baseCmTotal;
            $gcUsed = $cmTotal;
            $baseInvoiceTotal = 0;
            $invoiceTotal = 0;
        } else {
            $baseGcUsed = $baseGcBalance;
            $gcUsed = $order->getGiftcertAmount()-$order->getGiftcertInvoiced();
            $baseInvoiceTotal -= $baseGcUsed;
            $invoiceTotal -= $gcUsed;
        }

        $cm->setBaseGrandTotal($baseCmTotal);
        $cm->setGrandTotal($cmTotal);
        $cm->setBaseGiftcertAmount($baseGcUsed);
        $cm->setGiftcertAmount($gcUsed);

        return $this;
    }
}