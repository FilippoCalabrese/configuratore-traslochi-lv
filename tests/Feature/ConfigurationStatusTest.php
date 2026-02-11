<?php

use App\Models\Configuration;

it('sets status to in_progress by default', function () {
    $config = Configuration::create([
        'config_id' => 'test-config',
        'nome' => 'Mario Rossi',
        'email' => 'mario@example.com',
        'phone' => '3331234567',
    ]);

    expect($config->status)->toBe('in_progress');
});
