<?php

namespace Omnipay\MercadoPago\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class AcceptNotificationRequest extends
    AbstractRequest implements
    NotificationInterface
{
    /**
     * @var
     */
    protected $data;

    /**
     * Initialise the data from the server request.
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);

        $topic = $httpRequest->query->get('topic');

        if ($topic) {
            $id = $httpRequest->query->get('id');
        }
        else {
            $id = $httpRequest->query->get('merchant_order_id');
        }

        switch ($topic) {
            case 'payment':
                [
                    $payment,
                    $statusCode
                ] = $this->getPaymentData($id);

                if (!$this->isResponseSuccess($statusCode)) {
                    return [
                        $payment,
                        $statusCode
                    ];
                }

                $merchantOrder = $this->getMerchantOrderData($payment->order_id);
                break;

            case 'merchant_order':
            default:
                $merchantOrder = $this->getMerchantOrderData($id);
                break;
        }

        $this->data = $merchantOrder;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getTransactionStatus()
    {
        [
            $order,
            $statusCode
        ] = $this->data;

        if (!$this->isResponseSuccess($statusCode)) {
            return parent::STATUS_FAILED;
        }

        $paidAmount = 0;

        foreach ($order->payments as $payment) {
            if ($payment['status'] == 'approved') {
                $paidAmount += $payment['transaction_amount'];
            }
        }

        if ($paidAmount >= $order->total_amount) {
            if (count($order->shipments) > 0) {
                if ($order->shipments[0]->status == "ready_to_ship") {
                    return parent::STATUS_COMPLETED;
                }
            }
            else {
                return parent::STATUS_COMPLETED;
            }
        }

        return parent::STATUS_PENDING;
    }

    /**
     * Gateway Reference
     *
     * @return string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        [
            $order,
            $statusCode
        ] = $this->data;

        if (!$this->isResponseSuccess($statusCode)) {
            return null;
        }

        return $order->external_reference;
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage()
    {
        return null;
    }

    /**
     * @return mixed|string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Legacy support.
     *
     * @param mixed $data ignored
     * @return $this
     */
    public function sendData($data)
    {
        return $this;
    }
}