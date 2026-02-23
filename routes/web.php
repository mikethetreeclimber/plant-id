<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PlantId;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/plantId', PlantId::class);
