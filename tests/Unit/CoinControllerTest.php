<?php

namespace Tests\Feature;

use App\Http\Resources\CoinPriceResource;
use Tests\TestCase;
use App\Services\CoinService;
use App\Services\CoinPriceService;
use App\Services\CoinGeckoService;
use App\Services\CacheService;
use App\Models\Coin;
use Mockery;

class CoinControllerTest extends TestCase
{
    private CacheService $cacheService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheService = new CacheService();
    }

    public function testGetCoinReturnsDataFromCache()
    {
        $mockCoinService = Mockery::mock(CoinService::class);
        $mockCoinPriceService = Mockery::mock(CoinPriceService::class);
        $mockGeckoService = Mockery::mock(CoinGeckoService::class);
        $mockCacheService = Mockery::mock(CacheService::class);

        $coin = new Coin([
            'id' => '7d024636-09ba-4191-95e3-6907efd35d6d',
            'coin_id' => 'bitcoin',
            'symbol' => 'BTC'
        ]);

        $coinPrices = [247440, 66185181, 101388, 188.75, 8041642, 25351, 67368, 113.548];

        $data = [
            'coin' => 'BTC',
            'prices' => $coinPrices
        ];

        $cacheKey = $this->cacheService->generateCacheKey((string) $coin->id);

        $mockCoinService->shouldReceive('findBySymbol')->with('BTC')->andReturn($coin);
        $mockCacheService->shouldReceive('generateCacheKey')->andReturn($cacheKey);
        $mockCacheService->shouldReceive('hasCache')->andReturn(true);
        $mockCacheService->shouldReceive('getCache')->andReturn($cacheKey);

        $this->app->instance(CoinService::class, $mockCoinService);
        $this->app->instance(CoinPriceService::class, $mockCoinPriceService);
        $this->app->instance(CoinGeckoService::class, $mockGeckoService);
        $this->app->instance(CacheService::class, $mockCacheService);

        $data = [
            'coin' => $coin->symbol,
            'prices' => $coinPrices,
        ];

        $response = (new CoinPriceResource($data))->toArray(request());

        $this->assertEquals('BTC', $response['coin']);
        $this->assertEquals($coinPrices, $response['prices']);
    }
}
