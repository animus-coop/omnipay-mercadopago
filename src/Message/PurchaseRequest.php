<?php

namespace Omnipay\MercadoPago\Message;

class PurchaseRequest extends
    AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $items = $this->getItems();
        $itemsList = [];

        if ($items) {
            foreach ($items as $item) {
                $itemsList[] = [
                    'id'          => $item->getTransactionId(),
                    'title'       => $item->getTitle(),
                    'currency_id' => $item->getCurrency(),
                    'picture_url' => $item->getPictureUrl(),
                    'description' => $item->getDescription(),
                    'category_id' => $item->getCategoryId(),
                    'quantity'    => $item->getQuantity(),
                    'unit_price'  => (double)$this->formatCurrency($item->getAmount())
                ];
            }
        }
        else {
            $itemsList[] = [
                'id'          => $this->getTransactionId(),
                'title'       => $this->getTitle(),
                'currency_id' => $this->getCurrency(),
                'picture_url' => $this->getPictureUrl(),
                'description' => $this->getDescription(),
                'category_id' => $this->getCategoryId(),
                'quantity'    => $this->getQuantity(),
                'unit_price'  => (double)$this->formatCurrency($this->getAmount())
            ];
        }

        return [
            'external_reference'   => $this->getTransactionReference(),
            'items'                => $itemsList,
            'auto_return'          => $this->getAutoReturn(),
            "back_urls"            => [
                "success" => $this->getReturnUrl(),
                "failure" => $this->getCancelUrl(),
                "pending" => $this->getPendingUrl() ? $this->getPendingUrl() : $this->getCancelUrl()
            ],
            'notification_url'     => $this->getNotifyUrl(),
            'payment_methods'      => [
                'excluded_payment_methods' => $this->getExcludedPaymentMethods(),
                'excluded_payment_types'   => $this->getExcludedPaymentTypes(),
                'installments'             => $this->getInstallments()
            ],
            'expires'              => $this->getExpires(),
            'expiration_date_from' => $this->getExpirationDateFrom(),
            'expiration_date_to'   => $this->getExpirationDateTo(),
            'payer'                => $this->getPayer()
        ];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function sendData($data)
    {
        $url = $this->getEndpoint() . '?access_token=' . $this->getAccessToken();

        $httpRequest = $this->httpClient->request('POST',
            $url,
            [
                'Content-type' => 'application/json',
            ],
            json_encode($data));

        return $this->createResponse(json_decode($httpRequest->getBody()->getContents()),
            $httpRequest->getStatusCode());
    }

    /**
     * @param $data
     * @param $statusCode
     * @return PurchaseResponse
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new PurchaseResponse($this, $data, $statusCode);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return ($this->getTestMode() ? $this->testEndpoint : $this->endpoint) . '/checkout/preferences';
    }
}
