<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionarioController;

Route::resource('questionarios', QuestionarioController::class);
Route::get('/responder/{questionario}', [QuestionarioController::class, 'responder'])->name('responder.questionario');
Route::post('/responder/{questionario}', [QuestionarioController::class, 'salvarResposta'])->name('questionarios.salvarResposta');
Route::get('/resultado/{usuario}/{questionario}', [QuestionarioController::class, 'resultado'])->name('questionarios.resultado');
Route::delete('/questionarios/{id}', [QuestionarioController::class, 'apagarQuestionario'])->name('questionarios.apagarQuestionario');
Route::get('/questionarios/{id}', [QuestionarioController::class, 'show'])->name('questionarios.show');
Route::get('/questionarios/{id}/edit', [QuestionarioController::class, 'edit'])->name('questionarios.edit');
Route::put('/questionarios/{id}', [QuestionarioController::class, 'update'])->name('questionarios.update');
Route::get('/resultados', [QuestionarioController::class, 'resultados'])->name('resultados.index');
Route::get('/resultados/{questionario}', [QuestionarioController::class, 'resultadosPorQuestionario'])->name('resultados.por_questionario');
Route::delete('/resultados/{questionario}', [QuestionarioController::class, 'apagarResultados'])->name('resultados.apagar');