<?php


namespace App\Services;

use App\Repositories\CoinRepository;
use App\DTO\CoinDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoinService
{
    private CoinRepository $repository;

    public function __construct(CoinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findBySymbol(string $coin): CoinDTO
    {
        $coin = $this->repository->findBySymbol($coin);

        if (!$coin) {
            throw new ModelNotFoundException("Coin not found with symbol: {$coin}");
        }

        return CoinDTO::fromModel($coin);
    }

}
