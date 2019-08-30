# Omnipay: MercadoPago

**MercadoPago driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements MercadoPago support for Omnipay. 

**PHP ^7.1 required.**

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `manuvalle/omnipay-mercadopago` with Composer:

```
composer require league/omnipay manuvalle/omnipay-mercadopago
```

## Basic Usage

The following gateways are provided by this package:

* [MercadoPago Smart Checkout](https://www.mercadopago.com.ar/developers/es/guides/payments/web-payment-checkout/introduction)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Test Mode

Unlike some gateways, there is no test mode endpoint separate to the live mode endpoint, the
MercadoPago API endpoint is the same for test and for live. 

In order to perform tests, you must create 2 testing accounts: a seller and a buyer.

##### Request
```shell script
curl -X POST \
-H "Content-Type: application/json" \
"https://api.mercadopago.com/users/test_user?access_token=PROD_ACCESS_TOKEN" \
-d '{"site_id":"MLA"}'
```
##### Response
```json
{
    "id": 123456,
    "nickname": "TT123456",
    "password": "qatest123456",
    "site_status": "active",
    "email": "test_user_123456@testuser.com"
}
```

Login with one of the accounts and convert it to a Seller account.

Data created with test-mode accounts will never hit the credit card networks
and will never cost anyone money.

More information on the [Official Docs](https://www.mercadopago.com.ar/developers/es/guides/payments/web-payment-checkout/test-integration/).

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/thephpleague/omnipay-stripe/issues),
or better yet, fork the library and submit a pull request.