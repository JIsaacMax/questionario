<?php

namespace App\Http\Controllers;

use App\Models\Questionario;
use App\Models\Pergunta;
use App\Models\Resposta;
use Illuminate\Http\Request;

class QuestionarioController extends Controller
{
    public function index()
    {
        $questionarios = Questionario::with('perguntas.respostas')->get();
        return view('questionarios.index', compact('questionarios'));
    }

    public function create()
    {
        return view('questionarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['titulo' => 'required|string|max:255']);
        $questionario = Questionario::create($data);

        foreach ($request->perguntas as $perguntaData) {
            $pergunta = $questionario->perguntas()->create(['texto' => $perguntaData['texto']]);

            foreach ($perguntaData['respostas'] as $respostaData) {
                $pergunta->respostas()->create($respostaData);
            }
        }

        return redirect()->route('questionarios.index');
    }
}