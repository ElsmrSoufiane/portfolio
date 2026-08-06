<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home');
Route::livewire('/about', 'pages::about');
Route::livewire('/projects', 'pages::projects');
Route::livewire('/blog', 'pages::blog');
