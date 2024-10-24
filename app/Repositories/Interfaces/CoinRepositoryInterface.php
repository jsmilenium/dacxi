<?php

namespace App\Repositories\Interfaces;

use App\Models\Coin;
use Illuminate\Support\Collection;

interface CoinRepositoryInterface
{
    public function findBySymbol(string $coin): Coin;

}
