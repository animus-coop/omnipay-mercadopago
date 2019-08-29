<?php

namespace Omnipay\MercadoPago\Message;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @param $data
     * @return PurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->liveEndpoint . '/checkout/preferences';
    }
}