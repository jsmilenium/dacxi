<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CoinPrice extends Model
{
    use SoftDeletes;

    protected $table = 'coins_prices';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'coin_id',
        'price',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $casts = [
        'price' => 'decimal:24,10',
    ];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }

}
