<?php


namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheService
{
    /**
     * Generate cache key for the coin.
     *
     * @param string $coin_id
     * @return string
     */
    public function generateCacheKey(string $coin_id): string
    {
        return "coin_price_{$coin_id}_" . Carbon::now()->format('Y-m-d');
    }

    /**
     * Check if the cache exists.
     *
     * @param string $cacheKey
     * @return bool
     */
    public function hasCache(string $cacheKey): bool
    {
        return Cache::has($cacheKey);
    }

    /**
     * Get the cache.
     *
     * @param string $cacheKey
     * @return array|null
     */
    public function getCache(string $cacheKey): ?array
    {
        return Cache::get($cacheKey);
    }

    /**
     * Put the cache.
     *
     * @param string $cacheKey
     * @param array $data
     * @return void
     */
    public function putCache(string $cacheKey, array $data): void
    {
        Cache::put($cacheKey, $data, Carbon::now()->endOfDay());
    }

    public function forgetCache(string $cacheKey): void
    {
        Cache::forget($cacheKey);
    }
}
