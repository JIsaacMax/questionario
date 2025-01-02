<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionarioController;

Route::resource('questionarios', QuestionarioController::class);
