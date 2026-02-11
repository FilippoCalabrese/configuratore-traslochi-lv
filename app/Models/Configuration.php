<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'config_id',
        'nome',
        'email',
        'phone',
        'contact_consent',
        'luogo_carico',
        'luogo_scarico',
        'distanza_totale',
        'tempo_totale',
        'tipo_trasporto',
        'imballaggio',
        'ztl',
        'ascensore',
        'piano_carico',
        'piano_scarico',
        'stanze_selezionate',
        'furniture_config',
        'total_price',
        'total_carico_time',
        'total_scarico_time',
        'transport_cost',
        'booking_details',
        'current_step',
        'status',
    ];

    protected $casts = [
        'stanze_selezionate' => 'array',
        'furniture_config' => 'array',
        'booking_details' => 'array',
        'imballaggio' => 'boolean',
        'ztl' => 'boolean',
        'ascensore' => 'boolean',
        'contact_consent' => 'boolean',
        'distanza_totale' => 'decimal:2',
        'tempo_totale' => 'decimal:2',
        'total_price' => 'decimal:2',
        'total_carico_time' => 'decimal:2',
        'total_scarico_time' => 'decimal:2',
        'transport_cost' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'in_progress',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
