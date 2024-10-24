<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coins = [
            [
                'id' => Str::uuid(),
                'coin_id' => 'bitcoin',
                'symbol' => 'BTC',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'bitcoin-cash',
                'symbol' => 'BCH',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'litecoin',
                'symbol' => 'LTC',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'ethereum',
                'symbol' => 'ETH',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'dacxi',
                'symbol' => 'DACXI',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'chainlink',
                'symbol' => 'LINK',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'tether',
                'symbol' => 'USDT',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'stellar',
                'symbol' => 'XLM',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'polkadot',
                'symbol' => 'DOT',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'cardano',
                'symbol' => 'ADA',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'solana',
                'symbol' => 'SOL',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'avalanche-2',
                'symbol' => 'AVAX',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'terra-luna-classic',
                'symbol' => 'LUNC',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'matic-network',
                'symbol' => 'MATIC',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'usd-coin',
                'symbol' => 'USDC',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'binancecoin',
                'symbol' => 'BNB',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'ripple',
                'symbol' => 'XRP',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'uniswap',
                'symbol' => 'UNI',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'maker',
                'symbol' => 'MKR',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'basic-attention-token',
                'symbol' => 'BAT',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'the-sandbox',
                'symbol' => 'SAND',
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'coin_id' => 'eos',
                'symbol' => 'EOS',
                'is_active' => true,
                'created_at' => now(),
            ]
        ];
        DB::table('coins')->insert($coins);
    }
}
