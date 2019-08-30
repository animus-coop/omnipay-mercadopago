<?php

namespace Omnipay\MercadoPago\Message;

use Omnipay\Common\Message\NotificationInterface;

class AcceptNotificationRequest extends
    AbstractRequest implements
    NotificationInterface
{
    /**
     * @return mixed|null
     */
    public function getData()
    {
        $topic = $this->httpRequest->query->get('topic');

        if ($topic) {
            $id = $this->httpRequest->query->get('id');
        }
        else {
            $id = $this->httpRequest->query->get('merchant_order_id');
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

        return $merchantOrder;
    }

    /**
     * @return mixed
     */
    public function getTransactionStatus()
    {
        [
            $order,
            $statusCode
        ] = $this->getData();

        if (!$this->isResponseSuccess($statusCode)) {
            return NotificationInterface::STATUS_FAILED;
        }

        $paidAmount = 0;

        foreach ($order->payments as $payment) {
            if ($payment->status == 'approved') {
                $paidAmount += $payment->transaction_amount;
            }
        }

        if ($paidAmount >= $order->total_amount) {
            if (count($order->shipments) > 0) {
                if ($order->shipments[0]->status == "ready_to_ship") {
                    return NotificationInterface::STATUS_COMPLETED;
                }
            }
            else {
                return NotificationInterface::STATUS_COMPLETED;
            }
        }

        return NotificationInterface::STATUS_PENDING;
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
        ] = $this->getData();

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