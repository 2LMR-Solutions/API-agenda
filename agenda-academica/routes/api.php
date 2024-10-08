<?php

use App\Http\Controllers\Api\AtividadeController;
use App\Http\Controllers\Api\SubtarefaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/atividades', function (Request $request) {
//     return response()->json([
//         'nome' => true,
//         'message' => 'Listar usuários',
//     ],200);
// });

Route::get('/atividades',[AtividadeController::class,'index']);
Route::get('/atividades/{atividade}', [AtividadeController::class, 'show']);
Route::post('/atividades', [AtividadeController::class, 'store']);
Route::put('/atividades/{atividade}', [AtividadeController::class, 'update']);
Route::delete('/atividades/{atividade}', [AtividadeController::class, 'destroy']);

Route::get('/subtarefas',[SubtarefaController::class,'index']);
Route::get('/subtarefas/{atividade_id}', [SubtarefaController::class, 'buscarPorAtividadeId']);
Route::get('/subtarefas/{subtarefa}', [SubTarefaController::class, 'show']);
Route::put('/subtarefas/{subtarefa}/update', [SubtarefaController::class, 'update'])->name('subtarefas.update');
Route::post('/subtarefas', [SubTarefaController::class, 'store']);
Route::put('/subtarefas/{subtarefa}', [SubTarefaController::class, 'update']);
Route::delete('/subtarefas/{subtarefa}', [SubTarefaController::class, 'destroy']);
