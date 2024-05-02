<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'expenses';

    protected $fillable = [
        'card_id',
        'transaction',
    ];

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
