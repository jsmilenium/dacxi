<?php

namespace App\Repositories;

use App\Models\Coin;
use App\DTO\CoinDTO;
use App\Repositories\interfaces\CoinRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoinRepository implements CoinRepositoryInterface
{
    private Coin $model;

    public function __construct(Coin $model)
    {
        $this->model = $model;
    }

    public function findById(string $id): Coin
    {
        $coin = $this->model->find($id);

        if (!$coin) {
            throw new ModelNotFoundException("Coin not found with ID: {$id}");
        }

        return $coin;
    }

    public function findByCoin(string $coin): Coin
    {
        $coin = $this->model->where('symbol', $coin)->first();

        if (!$coin) {
            throw new ModelNotFoundException("Coin not found with symbol: {$coin}");
        }

        return $coin;
    }

    public function create(array $data): Coin
    {
        return $this->model->create([
            'coin_id' => $data['coin_id'],
            'symbol' => $data['symbol'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function list(): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('symbol')
            ->get();
    }
}
