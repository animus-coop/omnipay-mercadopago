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
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\MercadoPago\Message\PurchaseRequest', $parameters);
    }
}