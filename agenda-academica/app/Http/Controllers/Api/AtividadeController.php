<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AtividadeRequest;
use App\Models\Atividade;
use App\Models\Subtarefa;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtividadeController extends Controller
{
    public function index() : JsonResponse{
        $atividade = Atividade::orderBy('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'message' => $atividade,
        ],200);
    }

    public function show(Atividade $atividade) : JsonResponse{
        return response()->json([
            'status' => true,
            'tarefa' => $atividade,
        ],200);
    }

    public function store(Request $request): JsonResponse{
        DB::beginTransaction();
        try{
            // Recupera o último ID da tabela e adiciona 1 para o próximo
            $lastId = Atividade::max('id') ?? 0;
            $nextId = $lastId + 1;
    
            $atividade = Atividade::create([
                'id' => $nextId,
                'nome' => $request->nome,
                'desc' => $request->desc,
                'data_Inicio' => $request->data_Inicio,
                'data_Final' => $request->data_Final
            ]);
    
            DB::commit();
    
            return response()->json([
                'status' => true,
                'tarefa' => $atividade,
                'message' => "Tarefa cadastrada com sucesso",
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Tarefa não cadastrada",
            ],400);
        }
    }
    

    public function update(Request $request, Atividade $atividade) : JsonResponse{
        DB::beginTransaction();
        try{
            $atividade->update([
                'nome' => $request->nome,
                'desc' => $request->desc,
                'data_Inicio' => $request->data_Inicio,
                'data_Final' => $request->data_Final
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'tarefa' => $atividade,
                'message' => "Tarefa editada com sucesso",
            ],200);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Tarefa não editada",
            ],400);
        }
    }

    public function destroy(Atividade $atividade) : JsonResponse {
        DB::beginTransaction();
        try {
            // Excluir todas as subtarefas associadas à atividade
            $atividade->subtarefas()->delete(); // Certifique-se de que a relação está correta
    
            // Agora exclua a atividade
            $atividade->delete();
    
            DB::commit(); // Certifique-se de que você está comprometendo a transação
    
            return response()->json([
                'status' => true,
                'tarefa' => $atividade,
                'message' => "Tarefa removida com sucesso",
            ], 200);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Tarefa não removida",
            ], 400);
        }
    }
}