<?php

namespace Tests\Unit;

use App\Services\CoinService;
use App\Repositories\CoinRepository;
use App\Models\Coin;
use App\DTO\CoinDTO;
use Tests\TestCase;
use Mockery;

class CoinServiceTest extends TestCase
{
    public function testFindBySymbolReturnsCoinDTO()
    {
        $mockRepository = Mockery::mock(CoinRepository::class);

        $coin = new Coin([
            'id' => '7d024636-09ba-4191-95e3-6907efd35d6d',
            'coin_id' => 'bitcoin',
            'symbol' => 'BTC'
        ]);

        $mockRepository->shouldReceive('findBySymbol')
            ->with('BTC')
            ->andReturn($coin);

        $coinService = new CoinService($mockRepository);
        $coinDTO = $coinService->findBySymbol('BTC');

        $this->assertInstanceOf(CoinDTO::class, $coinDTO);
        $this->assertEquals('bitcoin', $coinDTO->coin_id);
        $this->assertEquals('BTC', $coinDTO->symbol);
    }
}
