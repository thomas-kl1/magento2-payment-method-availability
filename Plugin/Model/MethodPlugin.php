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

namespace Tklein\PaymentMethodAvailability\Plugin\Model;

use Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Product plugin which set the default qty to apply
 */
final class MethodPlugin
{
    /**
     * @var \Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface
     */
    private $methodProcessor;

    /**
     * @param \Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface $methodProcessor
     */
    public function __construct(
        MethodProcessorInterface $methodProcessor
    ) {
        $this->methodProcessor = $methodProcessor;
    }

    /**
     * Check wether the payment method is available or not
     *
     * @param \Magento\Payment\Model\MethodInterface $subject
     * @param bool $result
     * @param null|\Magento\Quote\Api\Data\CartInterface $quote
     * @return bool
     */
    public function afterIsAvailable(MethodInterface $subject, bool $result, ?CartInterface $quote = null): bool
    {
        return $result && $this->methodProcessor->isAvailable($subject->getCode(), $quote);
    }
}
