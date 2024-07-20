<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Calculator;

Route::GET('/', Calculator::class)->name('calculator');

