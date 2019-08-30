<?php

namespace Omnipay\MercadoPago;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\ItemBag;

class SmartCheckoutGateway extends
    AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'MercadoPago Smart Checkout';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'access_token' => '',
            'testMode'     => false,
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setAccessToken($value)
    {
        return $this->setParameter('access_token', $value);
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->getParameter('access_token');
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MercadoPago\Message\PurchaseRequest', $parameters);
    }

    /**
     * @return mixed
     */
    public function acceptNotification()
    {
        return $this->createRequest('\Omnipay\MercadoPago\Message\AcceptNotificationRequest', []);
    }
}