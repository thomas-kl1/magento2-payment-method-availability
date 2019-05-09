<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 *
 * @package         Payment Method Availability Module
 * @copyright       Copyright (c) Thomas Klein (https://thomas-kl1.github.io)
 * @author          Thomas Klein
 * @license         MIT
 * @support         https://github.com/thomas-kl1/magento2-payment-method-availability/issues/new
 */
declare(strict_types=1);

namespace Tklein\PaymentMethodAvailability\Model\Method;

use Magento\Quote\Api\Data\CartInterface;

/**
 * Class MaxAmountProcessor
 *
 * @package Tklein\PaymentMethodAvailability\Model\Method
 */
final class MaxAmountProcessor extends AbstractMethodProcessor
{
    /**
     * {@inheritdoc}
     * @param \Magento\Quote\Model\Quote $quote
     */
    public function checkAvailability(string $methodCode, CartInterface $quote): bool
    {
        $allowedAmount = $this->config->getMaxAllowedAmount($methodCode, (string) $quote->getStoreId());

        return $allowedAmount === null ?: $quote->getBaseGrandTotal() <= $allowedAmount;
    }
}
