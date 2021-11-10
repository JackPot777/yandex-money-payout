<?php

declare(strict_types=1);

namespace YandexPayout\Response;

use YandexMoney\PayoutAPI;

class ResponseAssertions
{
    /**
     * @var array
     */
    protected $rawResponse;

    public function isSuccessRequest(): bool
    {
        if (
            is_null($this->rawResponse) === false &&
            intval($this->rawResponse['status']) == PayoutAPI::REQ_STATUS_SUCCESS
        ) {
            return true;
        }
        return false;
    }

    protected function isClientOrderIdDublicate(): bool
    {
        if (
            $this->isRejectedRequest() &&
            intval($this->rawResponse['error']) == PayoutAPI::ERROR_NOT_UNIQUE_CLIENT_ORDER_ID
        ) {
            return true;
        }
        return false;
    }

    protected function isRejectedRequest(): bool
    {
        if (intval($this->rawResponse['status']) == PayoutAPI::REQ_STATUS_REJECTED) {
            return true;
        }
        return false;
    }
}
