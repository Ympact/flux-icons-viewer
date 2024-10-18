<?php

use App\Livewire\Pages\Documentation;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Icons;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);

Route::get('/docs', Documentation::class);

Route::get('/icons', Icons::class);
