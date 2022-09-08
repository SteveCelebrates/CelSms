<?php

/**
 * SteveCelebartes Free Software
 * 
 * @category CelSms_Smsnow
 * 
 * @author SteveCelebrates
 * 
 * Copyright © Steve Celebrates (2022), Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cel\Smsfree\Observer\Adminhtml;

use CelSms\Smsnow\Helper\Data;
use CelSms\Smsnow\Helper\ApiRef;
use Magento\Framework\Event\Observer;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Event\ObserverInterface;

class Shipment implements ObserverInterface
{
    protected $objectManager;
    protected $helperdata;
    protected $helperapi;

    public function __construct(
        ObjectManagerInterface $objectManager,
        Data $helperdata,
        ApiRef $helperapi
    ) {
        $this->objectManager = $objectManager;
        $this->helperdata = $helperdata;
        $this->helperapi = $helperapi;
    }

    public function execute(Observer $observer)
    {
        try {
            if ($this->helperdata->isEnabled() && $this->helperdata->isShipmentEnabledForUser()) {
                $shipment = $observer->getEvent()->getShipment();
                $order = $shipment->getOrder();
                $mobilenumber = $order->getBillingAddress()->getTelephone();
                $this->helperapi->callApiUrl($mobilenumber, $this->helperdata->getShipmenTemplateForUser());
            }
            return true;
        } catch (\Exception $e) {
            return true;
        }
    }
}