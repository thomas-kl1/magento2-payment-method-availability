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

use Tklein\PaymentMethodAvailability\Model\Config;
use Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface;
use Magento\Checkout\Model\Session;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Class AbstractMethodProcessor
 *
 * @package Tklein\PaymentMethodAvailability\Model\Method
 */
abstract class AbstractMethodProcessor implements MethodProcessorInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $session;

    /**
     * @var \Tklein\PaymentMethodAvailability\Model\Config
     */
    protected $config;

    /**
     * @param \Magento\Checkout\Model\Session $session
     * @param \Tklein\PaymentMethodAvailability\Model\Config $config
     */
    public function __construct(
        Session $session,
        Config $config
    ) {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    final public function isAvailable(string $methodCode, ?CartInterface $quote = null): bool
    {
        $quote = $quote ?? $this->session->getQuote();

        return $this->config->hasPaymentMethod($methodCode, (string) $quote->getStoreId())
            ? $this->checkAvailability($methodCode, $quote)
            : true;
    }

    /**
     * Check the payment method availability
     *
     * @param string $methodCode
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @return bool
     */
    abstract protected function checkAvailability(string $methodCode, CartInterface $quote): bool;
}
