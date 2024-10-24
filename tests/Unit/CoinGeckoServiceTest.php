<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use App\Services\CoinGeckoService;
use App\Exceptions\CoinGeckoApiException;
use GuzzleHttp\Exception\RequestException;

class CoinGeckoServiceTest extends TestCase
{
    public function testGetCoinPriceSuccess()
    {
        $mockResponseBody = [
            'market_data' => [
                'current_price' => [
                    'btc' => 50000,
                    'eos' => 42000
                ]
            ]
        ];

        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('get')
            ->once()
            ->with('coins/bitcoin', Mockery::on(function ($options) {
                return $options['headers']['x-cg-demo-api-key'] === env('COINGECKO_API_KEY');
            }))
            ->andReturn(new Response(200, [], json_encode($mockResponseBody)));

        $service = new CoinGeckoService();
        $this->setProtectedProperty($service, 'client', $mockClient);

        $result = $service->getCoinPrice('bitcoin');

        $this->assertEquals([
            'btc' => 50000,
            'eos' => 42000
        ], $result);
    }

    public function testGetCoinPriceThrowsExceptionOnFailure()
    {
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('get')
            ->andThrow(new RequestException('Error', new \GuzzleHttp\Psr7\Request('GET', 'coins/bitcoin')));

        $service = new CoinGeckoService();
        $this->setProtectedProperty($service, 'client', $mockClient);

        $this->expectException(CoinGeckoApiException::class);
        $service->getCoinPrice('bitcoin');
    }

    protected function setProtectedProperty($object, string $property, $value)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
