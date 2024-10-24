<?php

namespace App\Exceptions;

use Exception;

class CoinGeckoApiException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'External API Error',
            'message' => $this->getMessage()
        ], 503);
    }
}
