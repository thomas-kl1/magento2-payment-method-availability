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

namespace Tklein\PaymentMethodAvailability\Spi;

use Magento\Quote\Api\Data\CartInterface;

/**
 * Interface MethodProcessorInterface
 * @api
 */
interface MethodProcessorInterface
{
    /**
     * Check if a payment method is available
     *
     * @param string $methodCode
     * @param null|\Magento\Quote\Api\Data\CartInterface $quote
     * @return bool
     */
    public function isAvailable(string $methodCode, ?CartInterface $quote = null): bool;
}
