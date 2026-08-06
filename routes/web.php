<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', function () {
    return view('pages::home');
});
