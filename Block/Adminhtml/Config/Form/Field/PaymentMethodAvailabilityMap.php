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

namespace Tklein\PaymentMethodAvailability\Block\Adminhtml\Config\Form\Field;

use Tklein\PaymentMethodAvailability\Block\Adminhtml\Config\Form\Field\Select\PaymentMethods;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Phrase;

/**
 * Class PaymentMethodAvailabilityMap
 *
 * @package Tklein\PaymentMethodAvailability\Block\Adminhtml\Config\Form\Field
 */
final class PaymentMethodAvailabilityMap extends AbstractFieldArray
{
    /**
     * Retrieve the payment methods select renderer
     *
     * @return \Tklein\PaymentMethodAvailability\Block\Adminhtml\Config\Form\Field\Select\PaymentMethods
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPaymentMethodSelectRenderer(): PaymentMethods
    {
        if (!$this->hasData('payment_method_select_renderer')) {
            $this->setData(
                'payment_method_select_renderer',
                $this->getLayout()->createBlock(
                    PaymentMethods::class,
                    '',
                    ['data' => ['is_render_to_js_template' => true]]
                )
            );
        }

        return $this->getData('payment_method_select_renderer');
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn(
            'payment_method_code',
            [
                'label' => new Phrase('Payment Method'),
                'class' => 'payment-method',
                'renderer' => $this->getPaymentMethodSelectRenderer(),
            ]
        );
        $this->addColumn(
            'min_allowed_amount',
            [
                'label' => new Phrase('Min Allowed Amount'),
                'class' => 'min-allowed-amount validate-digits validate-zero-or-greater',
            ]
        );
        $this->addColumn(
            'max_allowed_amount',
            [
                'label' => new Phrase('Max Allowed Amount'),
                'class' => 'max-allowed-amount validate-digits validate-zero-or-greater',
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = (new Phrase('Add Payment Method Availability'))->render();
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $rowHash = $this->getPaymentMethodSelectRenderer()->calcOptionHash($row->getData('payment_method_code'));
        $row->setData('option_extra_attrs', ['option_' . $rowHash => 'selected="selected"']);
    }
}
