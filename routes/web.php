<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->get('/', function () {
    return 'Todo Api Service is up and running...';
});
