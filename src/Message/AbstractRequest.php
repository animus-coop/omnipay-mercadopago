<?php

namespace Omnipay\MercadoPago\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live endpoint url.
     *
     * @var string
     */
    protected $endpoint = 'https://api.mercadopago.com';

    /**
     * @param $data
     * @return mixed
     */
    public function sendData($data)
    {
        $url = $this->getEndpoint() . '?access_token=' . $this->getAccessToken();

        $httpRequest = $this->httpClient->request(
            'POST',
            $url,
            [
                'Content-type' => 'application/json',
            ],
            json_encode($data)
        );

        dd($httpRequest);
        
        return $this->createResponse(json_decode($httpRequest->getBody()->getContents()));
    }

    /**
     * @return mixed
     */
    abstract public function getEndpoint();
}