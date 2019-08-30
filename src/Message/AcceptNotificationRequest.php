<?php

namespace Omnipay\MercadoPago\Message;

class AcceptNotificationRequest extends
    AbstractRequest
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

        dd($topic, $id);

        switch ($topic) {
            case 'payment':
                $payment = $this->getPaymentData($id);
                $merchantOrder = $this->getMerchantOrderData($payment->order_id);
                break;

            case 'merchant_order':
            default:
                $merchantOrder = $this->getMerchantOrderData($id);
                break;
        }

//        $order = $merchantOrder[0];
//        $statusCode = $merchantOrder[1];
//        $paidAmount = 0;
//
//        foreach ($order->payments as $payment) {
//            if ($payment['status'] == 'approved') {
//                $paidAmount += $payment['transaction_amount'];
//            }
//        }
//
//        if ($paidAmount )
        ////    // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
        ////    if($paid_amount >= $merchant_order->total_amount){
        ////        if (count($merchant_order->shipments)>0) { // The merchant_order has shipments
        ////            if($merchant_order->shipments[0]->status == "ready_to_ship") {
        ////                print_r("Totally paid. Print the label and release your item.");
        ////            }
        ////        } else { // The merchant_order don't has any shipments
        ////            print_r("Totally paid. Release your item.");
        ////        }
        ////    } else {
        ////        print_r("Not paid yet. Do not release your item.");
        ////    }
        return $merchantOrder;
    }

    /**
     * @param $data
     * @return CompleteAcceptPurchaseResponse
     */
    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    /**
     * @param $data
     * @return CompletePurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * @return mixed|string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }
}