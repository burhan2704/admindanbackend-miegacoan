<?php

use Illuminate\Support\Facades\Route;

// Route untuk root URL '/'
// Route::get('/', function () {
//     return view('landing-page.landing-page');
// })->name('landing-page.root');

Route::prefix('landing-page')->group(function () {
    $pages = [
        '' => 'landing-page', // Menangani '/landing-page'
        'checkout-page' => 'checkout-page',
        'help-center-article' => 'help-center-article',
        'help-center-landing' => 'help-center-landing',
        'payment-page' => 'payment-page',
        'pricing-page' => 'pricing-page'
    ];

    collect($pages)->each(function ($view, $uri) {
        Route::get($uri, function () use ($view) {
            return view("landing-page.$view");
        })->name($view);
    });
});

