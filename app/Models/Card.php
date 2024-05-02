<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cards';

    protected $fillable = [
        'user_id',
        'number',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('order', function (Builder $builder) {
    //         $builder->latest();
    //     });
    // }

    // public function createdAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $createdAt) => Carbon::make($createdAt)->format('d/m/Y H:i'),
    //     );
    // }

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function support(): BelongsTo
    // {
    //     return $this->belongsTo(Support::class);
    // }
}
