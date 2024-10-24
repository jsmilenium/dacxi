<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoinPrice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'coin_id',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:24,10',
    ];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }

}
