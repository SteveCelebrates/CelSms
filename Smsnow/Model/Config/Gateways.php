<?php

namespace CelSms\Smsnow\Model\Config;

use CelSms\Smsnow\Helper\ApiRef;
use Magento\Framework\DataObject;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Option\ArrayInterface;

class Gateways extends DataObject implements ArrayInterface
{
    protected $apihelper;

    public function __construct(

        ApiRef $apihelper,
        array $data = []
    ) {
        $this->apihelper = $apihelper;
        parent::__construct($data);
    }

    public function toOptionArray()
    {
        $options = [['value' => '', 'label' => 'Select SMS Gatway']];
        foreach ($this->apihelper->getSmsgatewaylist() as $key => $smsgateway) {
            $Smsgatewaymodel = ObjectManager::getInstance()->create($smsgateway);
            $options[] = ['value' => $key, 'label' => $Smsgatewaymodel->getTitle()];
        }
        return $options;
    }
}