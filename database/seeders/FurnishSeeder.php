<?php

namespace Database\Seeders;

use App\Models\FurnishItem;
use App\Models\Room;
use Illuminate\Database\Seeder;

class FurnishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('furnish.json');
        if (! file_exists($path)) {
            return;
        }

        $data = json_decode(file_get_contents($path), true);
        if (! is_array($data)) {
            return;
        }

        foreach ($data as $roomName => $items) {
            $room = Room::firstOrCreate([
                'name' => $roomName,
            ]);

            if (! is_array($items)) {
                continue;
            }

            foreach ($items as $item) {
                if (! isset($item['name'])) {
                    continue;
                }

                FurnishItem::updateOrCreate(
                    [
                        'room_id' => $room->id,
                        'name' => $item['name'],
                    ],
                    [
                        'image' => $item['image'] ?? null,
                        'min_properties' => $item['minProperties'] ?? null,
                        'label' => $item['label'] ?? null,
                        'base_price' => $item['price'] ?? null,
                        'base_m3' => $item['m3'] ?? null,
                        'base_tempo_carico' => $item['tempo_carico'] ?? null,
                        'base_tempo_scarico' => $item['tempo_scarico'] ?? null,
                        'properties' => $item['properties'] ?? null,
                    ]
                );
            }
        }
    }
}
