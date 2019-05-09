# Payment Method Availability

[![Latest Stable Version](https://img.shields.io/packagist/v/tklein/module-payment-method-availability.svg?style=flat-square)](https://packagist.org/packages/tklein/module-payment-method-availability)
[![License: MIT](https://img.shields.io/github/license/thomas-kl1/magento2-payment-method-availability.svg?style=flat-square)](./LICENSE)  

This module allows you to define payment method availability dynamically.
The free source is available at the [github repository](https://github.com/thomas-kl1/magento2-payment-method-availability).

**THIS REPOSITORY HAS BEEN ARCHIVED.**  
**PLEASE, READ THE "[DEVELOPERS](#developers)" SECTION.**
**THIS MODULE IS A FALSE ANSWER TO A FALSE PROBLEM.**

## Setup

```
composer require tklein/module-payment-method-availability
```

Go to your Magento root, then run the following magento command:

```
php bin/magento setup:upgrade
```

**If you are in production mode, do not forget to recompile and redeploy the static resources, or to use the `--keep-generated` option.**

## Settings

***Customize the module without efforts.***

### Administrators

The following settings are available at `Stores > Configuration > Sales > Payment Methods > Other Payment Methods > Default Payment Method Settings`:  

- **Payment Method Availability**: Manage the payment methods availability with the minimum and maximum allowed amount.

## Developers

Please see the following API first, maybe it could resolve your issue:

```xml
    <type name="Magento\Payment\Model\Checks\SpecificationFactory">
        <arguments>
            <argument name="mapping" xsi:type="array">
                <item name="country" xsi:type="object">Magento\Payment\Model\Checks\CanUseForCountry</item>
                <item name="currency" xsi:type="object">Magento\Payment\Model\Checks\CanUseForCurrency</item>
                <item name="checkout" xsi:type="object">Magento\Payment\Model\Checks\CanUseCheckout</item>
                <item name="internal" xsi:type="object">Magento\Payment\Model\Checks\CanUseInternal</item>
                <item name="total" xsi:type="object">Magento\Payment\Model\Checks\TotalMinMax</item>
                <item name="zero_total" xsi:type="object">Magento\Payment\Model\Checks\ZeroTotal</item>
            </argument>
        </arguments>
    </type>
```

Where the specifications implements the following interface: `\Magento\Payment\Model\Checks\SpecificationInterface`.

In the case of the gateway API, please refer to the validator pool:

`Magento\Payment\Gateway\Validator\ValidatorPool`

## Support

- If you have any issue with this code, feel free to [open an issue](https://github.com/thomas-kl1/magento2-payment-method-availability/issues/new).  
- If you want to contribute to this project, feel free to [create a pull request](https://github.com/thomas-kl1/magento2-payment-method-availability/compare).

## Authors

- **Thomas Klein** - *Maintainer* - [It's me!](https://github.com/thomas-kl1)

## Licence

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

***That's all folks!***
