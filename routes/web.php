<?php

use App\Livewire\Configuratore;
use Illuminate\Support\Facades\Route;

Route::get('/', Configuratore::class)->name('home');
