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

namespace CelSms\Smsnow\Helper;

use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    //Main Configuration
    const XML_PATH_ENABLED = 'smsnow/moduleoption/enable';

    //User template configuration
    const XML_SMS_USER_ORDER_PLACE_ENABLE = 'smsnow/orderplace/enable';
    const XML_SMS_USER_USER_ORDER_PLACE_TEXT = 'smsnow/orderplace/template';
    const XML_SMS_USER_SHIPMENT_ENABLE = 'smsnow/shipment/enable';
    const XML_SMS_USER_SHIPMENT_TEXT = 'smsnow/shipment/template';

    protected $_storeManager;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        Registry $registry,
        StoreManagerInterface $storeManager
    ) {
        $this->registry = $registry;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getStoreid()
    {
        return $this->_storeManager->getStore()->getId();
    }
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid()
        );
    }
    public function isOrderPlaceForUserEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_SMS_USER_ORDER_PLACE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid()
        );
    }
    public function getOrderPlaceTemplateForUser()
    {
        return $this->scopeConfig->getValue(
            self::XML_SMS_USER_USER_ORDER_PLACE_TEXT,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid()
        );
    }
    public function isShipmentEnabledForUser()
    {
        return $this->scopeConfig->getValue(
            self::XML_SMS_USER_SHIPMENT_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid()
        );
    }
    public function getShipmenTemplateForUser()
    {
        return $this->scopeConfig->getValue(
            self::XML_SMS_USER_SHIPMENT_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid()
        );
    }
}