<?php

namespace Omnipay\MercadoPago\Message;

abstract class AbstractRequest extends
    \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live endpoint url.
     *
     * @var string
     */
    protected $endpoint = 'https://api.mercadopago.com';

    /**
     * @return mixed
     */
    abstract public function getEndpoint();

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
     * Get payment data from id.
     *
     * @param $id
     * @return array
     */
    public function getPaymentData($id)
    {
        $url = $this->getEndpoint() . '/v1/payments' . $id . '?access_token=' . $this->getAccessToken();

        $httpRequest = $this->httpClient->request('GET',
            $url,
            [
                'Content-type' => 'application/json',
            ]);

        return [
            json_decode($httpRequest->getBody()->getContents()),
            $httpRequest->getStatusCode()
        ];
    }

    /**
     * Get merchant order data from id.
     *
     * @param $id
     * @return array
     */
    public function getMerchantOrder($id)
    {
        $url = $this->getEndpoint() . '/merchant_orders/' . $id . '?access_token=' . $this->getAccessToken();

        $httpRequest = $this->httpClient->request('GET',
            $url,
            [
                'Content-type' => 'application/json',
            ]);

        return [
            json_decode($httpRequest->getBody()->getContents()),
            $httpRequest->getStatusCode()
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTitle($value)
    {
        return $this->setParameter('title', $value);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getParameter('title');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setPictureUrl($value)
    {
        return $this->setParameter('picture_url', $value);
    }

    /**
     * @return mixed
     */
    public function getPictureUrl()
    {
        return $this->getParameter('picture_url');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setCategoryId($value)
    {
        return $this->setParameter('category_id', $value);
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->getParameter('category_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setQuantity($value)
    {
        return $this->setParameter('quantity', $value);
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->getParameter('quantity');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setAutoReturn($value)
    {
        return $this->setParameter('auto_return', $value);
    }

    /**
     * @return mixed
     */
    public function getAutoReturn()
    {
        return $this->getParameter('auto_return') ? $this->getParameter('auto_return') : 'approved';
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setPendingUrl($value)
    {
        return $this->setParameter('pendingUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getPendingUrl()
    {
        return $this->getParameter('pendingUrl');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setExcludedPaymentMethods($values)
    {
        $excludedMethods = [];

        foreach ($values as $value) {
            $excludedMethods[] = [
                'id' => $value
            ];
        }

        return $this->setParameter('excluded_payment_methods', $excludedMethods);
    }

    /**
     * @return mixed
     */
    public function getExcludedPaymentMethods()
    {
        return $this->getParameter('excluded_payment_methods');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setExcludedPaymentTypes($values)
    {
        $excludedTypes = [];

        foreach ($values as $value) {
            $excludedTypes[] = [
                'id' => $value
            ];
        }

        return $this->setParameter('excluded_payment_types', $excludedTypes);
    }

    /**
     * @return mixed
     */
    public function getExcludedPaymentTypes()
    {
        return $this->getParameter('excluded_payment_types');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setInstallments($value)
    {
        return $this->setParameter('installments', $value);
    }

    /**
     * @return mixed
     */
    public function getInstallments()
    {
        return $this->getParameter('installments');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setExpires($value)
    {
        return $this->setParameter('expires', $value);
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->getParameter('expires');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setExpirationDateFrom($value)
    {
        return $this->setParameter('expiration_date_from', $value);
    }

    /**
     * @return mixed
     */
    public function getExpirationDateFrom()
    {
        return $this->getParameter('expiration_date_from');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setExpirationDateTo($value)
    {
        return $this->setParameter('expiration_date_to', $value);
    }

    /**
     * @return mixed
     */
    public function getExpirationDateTo()
    {
        return $this->getParameter('expiration_date_to');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setPayer($value)
    {
        return $this->setParameter('payer', $value);
    }

    /**
     * @return mixed
     */
    public function getPayer()
    {
        return $this->getParameter('payer');
    }
}