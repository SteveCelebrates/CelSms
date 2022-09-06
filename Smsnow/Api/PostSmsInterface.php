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

namespace CelSms\Smsnow\Api;

interface PostSmsInterface
{
    /**
     * POST api for Order placed notification
     * @param string $orderid
     * @param string $message
     * @return string
     */

    public function placedOrder($orderid, $message);

    /**
     * POST api for Order shipped notification
     * @param string $orderid
     * @param string $message
     * @return string
     */

    public function shippedOrder($orderid, $message);
}