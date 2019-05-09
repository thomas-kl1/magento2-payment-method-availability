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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Module configuration settings container
 * @api
 */
final class Config
{
    /**#@+
     * Scope Config: Data Settings Paths
     */
    public const CONFIG_PATH_PAYMENT_METHOD_AVAILABILITY_MAP = 'payment/default_payment_method_settings/availability_map';
    /**#@-*/

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $mappers;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
        $this->mappers = [];
    }

    /**
     * Retrieve the payment method availability meta data
     *
     * @param string|null $methodCode
     * @param string|null $scopeCode
     * @return array
     */
    public function getMetaData(?string $methodCode = null, ?string $scopeCode = null): array
    {
        $scope = $scopeCode ?? 'current_scope';

        if (!isset($this->mappers[$scope])) {
            $mapper = [];
            $rawData = $this->serializer->unserialize(
                $this->scopeConfig->getValue(
                    self::CONFIG_PATH_PAYMENT_METHOD_AVAILABILITY_MAP,
                    ScopeInterface::SCOPE_STORE,
                    $scopeCode
                ) ?? '{}'
            );

            foreach ($rawData as $data) {
                $mapper[$data['payment_method_code']] = $data;
            }

            $this->mappers[$scope] = $mapper;
        }

        return $methodCode ? ($this->mappers[$scope][$methodCode] ?? []) : $this->mappers[$scope];
    }

    /**
     * Check wether the payment method has configured settings
     *
     * @param string $methodCode
     * @param string|null $scopeCode
     * @return bool
     */
    public function hasPaymentMethod(string $methodCode, ?string $scopeCode = null): bool
    {
        return (bool) $this->getMetaData($methodCode, $scopeCode);
    }

    /**
     * Retrieve the minimum allowed amount
     *
     * @param string $methodCode
     * @param string|null $scopeCode
     * @return float|null
     */
    public function getMinAllowedAmount(string $methodCode, ?string $scopeCode = null): ?float
    {
        return isset($this->getMetaData($methodCode, $scopeCode)['min_allowed_amount'])
            ? (float) $this->getMetaData($methodCode, $scopeCode)['min_allowed_amount']
            : null;
    }

    /**
     * Retrieve the maximum allowed amount
     *
     * @param string $methodCode
     * @param string|null $scopeCode
     * @return float|null
     */
    public function getMaxAllowedAmount(string $methodCode, ?string $scopeCode = null): ?float
    {
        return isset($this->getMetaData($methodCode, $scopeCode)['max_allowed_amount'])
            ? (float) $this->getMetaData($methodCode, $scopeCode)['max_allowed_amount']
            : null;
    }
}
