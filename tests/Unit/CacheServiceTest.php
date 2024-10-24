<?php


namespace Tests\Unit;

use App\Services\CacheService;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheServiceTest extends TestCase
{
    private CacheService $cacheService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheService = new CacheService();
    }

    public function testGenerateCacheKey()
    {
        $coin_id = 'bitcoin';
        $expectedKey = "coin_price_{$coin_id}_" . Carbon::now()->format('Y-m-d');

        $cacheKey = $this->cacheService->generateCacheKey($coin_id);

        $this->assertEquals($expectedKey, $cacheKey);
    }

    public function testPutAndGetCache()
    {
        $cacheKey = 'test_key';
        $data = ['price' => 1000];

        $this->cacheService->putCache($cacheKey, $data);

        $cachedData = $this->cacheService->getCache($cacheKey);

        $this->assertEquals($data, $cachedData);
    }

    public function testHasCache()
    {
        $cacheKey = 'test_key';
        Cache::put($cacheKey, ['price' => 1000], Carbon::now()->endOfDay());

        $this->assertTrue($this->cacheService->hasCache($cacheKey));
    }
}
