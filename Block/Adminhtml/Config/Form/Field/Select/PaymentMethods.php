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

namespace Tklein\PaymentMethodAvailability\Block\Adminhtml\Config\Form\Field\Select;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use Magento\Payment\Api\PaymentMethodListInterface;
use Magento\Store\Model\Store;

/**
 * Class PaymentMethods
 *
 * @package Tklein\PaymentMethodAvailability\Block\Adminhtml\Config\Form\Field\Select
 */
final class PaymentMethods extends Select
{
    /**
     * @var \Magento\Payment\Api\PaymentMethodListInterface
     */
    private $paymentMethodList;

    /**
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Payment\Api\PaymentMethodListInterface $paymentMethodList
     * @param array $data
     */
    public function __construct(
        Context $context,
        PaymentMethodListInterface $paymentMethodList,
        array $data = []
    ) {
        $this->paymentMethodList = $paymentMethodList;
        parent::__construct($context, $data);
    }

    /**
     * Set the input name
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value): self
    {
        return $this->setData('name', $value);
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml(): string
    {
        if (!$this->getOptions()) {
            foreach ($this->paymentMethodList->getList(Store::DEFAULT_STORE_ID) as $paymentMethod) {
                $this->addOption($paymentMethod->getCode(), $paymentMethod->getTitle());
            }
        }

        return parent::_toHtml();
    }
}
