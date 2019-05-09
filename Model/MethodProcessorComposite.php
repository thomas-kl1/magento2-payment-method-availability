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

namespace Tklein\PaymentMethodAvailability\Model;

use Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Class MethodProcessorComposite
 * @api
 */
final class MethodProcessorComposite implements MethodProcessorInterface
{
    /**
     * @var \Tklein\PaymentMethodAvailability\Model\MethodProcessorFactory
     */
    private $methodProcessorFactory;

    /**
     * @var string[][]
     */
    private $methodProcessorPool;

    /**
     * @param \Tklein\PaymentMethodAvailability\Model\MethodProcessorFactory $methodProcessorFactory
     * @param string[][] $methodProcessorPool
     */
    public function __construct(
        MethodProcessorFactory $methodProcessorFactory,
        array $methodProcessorPool
    ) {
        $this->methodProcessorFactory = $methodProcessorFactory;
        $this->methodProcessorPool = $methodProcessorPool;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable(string $methodCode, ?CartInterface $quote = null): bool
    {
        $processors = \array_merge($this->methodProcessorPool['default'], $this->methodProcessorPool[$methodCode] ?? []);

        /** @var \Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface $processor */
        foreach ($processors as $processorName) {
            $processor = $this->methodProcessorFactory->get($processorName);
            if (!$processor->isAvailable($methodCode, $quote)) {
                return false;
            }
        }

        return true;
    }
}
