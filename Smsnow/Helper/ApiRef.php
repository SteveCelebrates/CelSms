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

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class ApiRef extends AbstractHelper
{
    const XML_PATH_SMSGATEWAY = 'smsnow/smsgateways/gateway';

    protected $smsgatewaylist;
    protected $_storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        array $smsgatewaylist = []
    ) {
        $this->smsgatewaylist = $smsgatewaylist;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getStoreid()
    {
        return $this->_storeManager->getStore()->getId();
    }
    public function getSmsgatewaylist()
    {
        return $this->smsgatewaylist;
    }
    public function getSelectedGateway()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SMSGATEWAY,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid()
        );
    }
    public function getSelectedGatewayModel()
    {
        $Selectedgateway = $this->smsgatewaylist[$this->getSelectedGateway()];
        return ObjectManager::getInstance()->create($Selectedgateway);
    }
    public function callApiUrl($mobilenumbers, $message)
    {
        $curentsmsModel = $this->getSelectedGatewayModel();

        if (!$curentsmsModel) {
            $this->_logger->error(__("You haven't configured the SMS Gateway."));
            return;
        }

        if (!$curentsmsModel->validateSmsConfig()) {
            $this->_logger->error(__("Please Configure all SMS Gateways."));
            return;
        }

        return $curentsmsModel->callApiUrl($mobilenumbers, $message);
    }
}