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

namespace CelSms\Smsnow\Model;

use CelSms\Smsnow\Api\PostSmsInterface;
use CelSms\Smsnow\Helper\Data;
use Magento\Sales\Model\OrderRepository;
use CelSms\Smsnow\Helper\ApiRef;
use Exception;

class PostMgt implements PostSmsInterface
{
    protected $helper;
    protected $orderrepository;
    protected $helperapi;

    public function __construct(
        Data $helper,
        OrderRepository $orderrepository,
        ApiRef $helperapi
    ) {
        $this->helper = $helper;
        $this->orderrepository = $orderrepository;
        $this->helperapi = $helperapi;
    }

    public function placedOrder($orderid, $message)
    {
        try {
            if ($this->helper->isOrderPlaceForUserEnabled()) {
                $ordercollection = $this->orderrepository->get($orderid);
                $number = $ordercollection->getBillingAddress()->getTelephone();
                $this->helperapi->callApiUrl($number, $message);
                $response = ['status' => true, 'message' => "Order message has been sent to the number."];
            } else {
                $response = ['status' => false, 'message' => "Enable notification for order placed"];
            }
        } catch (\Exception $e) {
            $response = ['error' => $e->getMessage()];
        }
        return json_encode($response);
    }

    public function shippedOrder($orderid, $message)
    {
        try {
            if ($this->helper->isOrderPlaceForUserEnabled()) {
                $ordercollection = $this->orderrepository->get($orderid);
                $number = $ordercollection->getBillingAddress()->getTelephone();
                $orderstatus = $ordercollection->hasShipments();
                if ($orderstatus) {
                    $this->helperapi->callApiUrl($number, $message);
                    $response = ['status' => true, 'message' => "Shipped Message sent to the Number."];
                } else {
                    $response = ['status' => false, 'message' => "The order is not Shipped."];
                }
            } else {
                $response = ['status' => false, 'message' => "Enable Notification for order shipped."];
            }
        } catch (\Exception $e) {
            $response = ['error' => $e->getMessage()];
        }
        return json_encode($response);
    }
}