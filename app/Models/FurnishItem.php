<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FurnishItem extends Model
{
    /** @use HasFactory<\Database\Factories\FurnishItemFactory> */
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'image',
        'min_properties',
        'label',
        'base_price',
        'base_m3',
        'base_tempo_carico',
        'base_tempo_scarico',
        'properties',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
