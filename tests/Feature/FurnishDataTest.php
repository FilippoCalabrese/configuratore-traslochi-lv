<?php

use App\Livewire\Configuratore;
use App\Models\FurnishItem;
use App\Models\Room;

it('returns furnish data from database when available', function () {
    $room = Room::factory()->create([
        'name' => 'Test Room',
    ]);

    FurnishItem::factory()->create([
        'room_id' => $room->id,
        'name' => 'Test Item',
        'properties' => [
            [
                'name' => 'Size',
                'price' => 10,
            ],
        ],
    ]);

    $component = new Configuratore;
    $data = $component->getFurnishData();

    expect($data)->toHaveKey('Test Room');
    expect($data['Test Room'])->toBeArray();
    expect($data['Test Room'][0]['name'])->toBe('Test Item');
});
