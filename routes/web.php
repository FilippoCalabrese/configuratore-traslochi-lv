<?php

use App\Http\Controllers\StripeCheckoutController;
use App\Livewire\Configuratore;
use Illuminate\Support\Facades\Route;

Route::get('/', Configuratore::class)->name('home');

Route::prefix('stripe')->name('stripe.')->group(function () {
    Route::post('/checkout', [StripeCheckoutController::class, 'createCheckoutSession'])->name('checkout');
    Route::get('/success', [StripeCheckoutController::class, 'success'])->name('success');
    Route::get('/cancel', [StripeCheckoutController::class, 'cancel'])->name('cancel');
    Route::post('/webhook', [StripeCheckoutController::class, 'webhook'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->name('webhook');
});
