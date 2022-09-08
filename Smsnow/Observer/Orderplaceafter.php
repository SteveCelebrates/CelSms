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

namespace CelSms\Smsnow\Observer;

use CelSms\Smsnow\Helper\Data;
use CelSms\Smsnow\Helper\ApiRef;
use Magento\Framework\Event\Observer;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Event\ObserverInterface;

class Orderplaceafter implements ObserverInterface
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
            if ($this->helperdata->isEnabled() && $this->helperdata->isOrderPlaceForUserEnabled()) {
                $order_id = $observer->getData('order_ids');
                $order = $this->objectManager->create('Magento\Sales\Model\Order')->load($order_id[0]);
                $order_information = $order->loadByIncrementId($order_id[0]);
                $this->helperapi->callApiUrl($order_information->getBillingAddress()->getTelephone(), $this->helperdata->getOrderPlaceTemplateForUser());
            }
            return true;
        } catch (\Exception $e) {
            return true;
        }
    }
}