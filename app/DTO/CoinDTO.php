<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Model;

class CoinDTO
{

    public $id;
    public string $symbol;

    public function __construct(string $id, string $coin_id, string $symbol)
    {
        $this->id = $id;
        $this->coin_id = $coin_id;
        $this->symbol = $symbol;
    }

    public static function fromModel(Model $model): self
    {
        return new self(
            (string) $model->id,
            (string) $model->coin_id,
            (string) $model->symbol
        );
    }
}
