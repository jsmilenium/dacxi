<?php

use App\Exceptions\CoinGeckoApiException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiErrorResponse
{
    /**
     * @var array
     */
    private static array $errorMessages = [
        ModelNotFoundException::class => [
            'status' => 404,
            'error' => 'Coin Not Found',
            'messageTemplate' => 'Symbol {symbol} not found in our database'
        ],
        CoinGeckoApiException::class => [
            'status' => 503,
            'error' => 'External API Error',
            'messageTemplate' => null
        ],
        GuzzleException::class => [
            'status' => 503,
            'error' => 'External API Error',
            'messageTemplate' => 'An error occurred while fetching data from external API'
        ]
    ];

    /**
     * @param Exception $e
     * @param array $context
     * @return array
     */
    public static function format(Exception $e, array $context = []): array
    {
        $errorConfig = self::getErrorConfig($e);

        return [
            'status' => $errorConfig['status'],
            'response' => [
                'error' => $errorConfig['error'],
                'message' => self::formatMessage($e, $errorConfig, $context)
            ]
        ];
    }

    /**
     * @param Exception $e
     * @return array
     */
    private static function getErrorConfig(Exception $e): array
    {
        foreach (self::$errorMessages as $exceptionClass => $config) {
            if ($e instanceof $exceptionClass) {
                return $config;
            }
        }

        // Default error config
        return [
            'status' => 500,
            'error' => 'Internal Server Error',
            'messageTemplate' => 'An unexpected error occurred'
        ];
    }

    /**
     * @param Exception $e
     * @param array $config
     * @param array $context
     * @return string
     */
    private static function formatMessage(Exception $e, array $config, array $context): string
    {
        if ($config['messageTemplate'] === null) {
            return $e->getMessage();
        }

        return strtr($config['messageTemplate'], $context);
    }
}
