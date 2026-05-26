<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    $index = public_path('index.html');

    if (!file_exists($index)) {
        abort(404);
    }

    return response()->file($index);
})->where('any', '.*');
