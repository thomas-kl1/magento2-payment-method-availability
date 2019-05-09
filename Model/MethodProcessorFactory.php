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
use Magento\Framework\ObjectManagerInterface;

/**
 * Class MethodProcessorFactory
 *
 * @package Tklein\PaymentMethodAvailability\Model
 */
final class MethodProcessorFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * Retrieve the method processor
     *
     * @param string $className
     * @return \Tklein\PaymentMethodAvailability\Spi\MethodProcessorInterface
     */
    public function get(string $className): MethodProcessorInterface
    {
        return $this->objectManager->get($className);
    }
}
