<?php

namespace App\Repositories\interfaces;

use App\Models\Coin;
use Illuminate\Support\Collection;

interface CoinRepositoryInterface
{
    public function findById(string $id): Coin;
    public function findByCoin(string $coin): Coin;

    public function create(array $data): Coin;
    public function list(): Collection;
}
