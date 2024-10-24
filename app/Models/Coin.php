<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method where(string $string, string $coin)
 */
class Coin extends Model
{

    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'coin_id',
        'symbol',
    ];


    public function prices(): HasMany
    {
        return $this->hasMany(CoinPrice::class);
    }
}
