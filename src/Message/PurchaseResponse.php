<?php

namespace Omnipay\MercadoPago\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class PurchaseResponse extends
    AbstractResponse implements
    RedirectResponseInterface
{
    protected $statusCode;

    /**
     * PurchaseResponse constructor.
     * @param RequestInterface $request
     * @param $data
     * @param int $statusCode
     */
    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }


    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($this->data->error) && $this->isResponseSuccess($this->statusCode);
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return isset($this->data->init_point) && $this->data->init_point;
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return |null
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * @return |null
     */
    public function getMessage()
    {
        return isset($this->data->message) ? $this->data->message : null;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->data->init_point;
        }
    }
}