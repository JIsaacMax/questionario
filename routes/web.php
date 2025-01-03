<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionarioController;

Route::resource('questionarios', QuestionarioController::class);
Route::get('/responder/{questionario}', [QuestionarioController::class, 'responder'])->name('responder.questionario');
Route::post('/responder/{questionario}', [QuestionarioController::class, 'salvarResposta'])->name('questionarios.salvarResposta');
Route::get('/resultado/{usuario}/{questionario}', [QuestionarioController::class, 'resultado'])->name('questionarios.resultado');