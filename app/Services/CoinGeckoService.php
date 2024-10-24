<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Exceptions\CoinGeckoApiException;
use GuzzleHttp\Exception\GuzzleException;

class CoinGeckoService
{
    private Client $client;
    private $baseUrl;
    private int $timeout;
    private int $retryAttempts;
    private int $retryDelay;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('COINGECKO_API_URL');
        $this->timeout = (int) env('COINGECKO_TIMEOUT', 30);
        $this->retryAttempts = (int) env('COINGECKO_RETRY_ATTEMPTS', 3);
        $this->retryDelay = (int) env('COINGECKO_RETRY_DELAY', 1000);
        $this->apiKey = env('COINGECKO_API_KEY');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
        ]);
    }

    /**
     * @throws CoinGeckoApiException
     * @throws GuzzleException
     */
    public function getCoinPrice(string $coinId): array
    {
        $attempt = 1;

        while ($attempt <= $this->retryAttempts) {
            try {
                $response = $this->client->get("coins/{$coinId}", [
                    'headers' => [
                        'x-cg-demo-api-key' => $this->apiKey, // Incluindo a API Key no header
                    ],
                ]);

                $data = json_decode($response->getBody(), true);
                $prices = $data['market_data']['current_price'] ?? null;

                if (!$prices) {
                    throw new CoinGeckoApiException('Invalid response from CoinGecko API');
                }

                return $prices;
            } catch (\Exception $e) {
                if ($attempt === $this->retryAttempts) {
                    throw new CoinGeckoApiException($e->getMessage());
                }
                usleep($this->retryDelay * 1000); // Aguardar antes da próxima tentativa
                $attempt++;
            }
        }

        throw new CoinGeckoApiException("Failed to get price after {$this->retryAttempts} attempts");
    }
}
