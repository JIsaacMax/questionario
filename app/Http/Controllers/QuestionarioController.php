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
    // Valide os dados enviados
    $data = $request->validate(['titulo' => 'required|string|max:255']);
    $questionario = Questionario::create($data);

    foreach ($request->perguntas as $perguntaData) {
        // Crie a pergunta
        $pergunta = $questionario->perguntas()->create([
            'texto' => $perguntaData['texto'],
        ]);

        $corretas = 0;

        foreach ($perguntaData['respostas'] as $index => $respostaData) {
            // Verifique se $respostaData é um array e contém a chave 'texto'
            if (!is_array($respostaData) || !isset($respostaData['texto'])) {
                return redirect()->back()->withErrors([
                    'error' => 'Formato inválido das respostas enviadas.',
                ]);
            }

            // Identifique se a resposta é correta
            $isCorreta = isset($perguntaData['correta']) && $perguntaData['correta'] == $index;

            if ($isCorreta) {
                $corretas++;
            }

            // Impedir múltiplas respostas corretas
            if ($corretas > 1) {
                return redirect()->back()->withErrors([
                    'error' => 'Cada pergunta só pode ter uma única resposta correta.',
                ]);
            }

            // Crie a resposta
            $pergunta->respostas()->create([
                'texto' => $respostaData['texto'],
                'correta' => $isCorreta,
            ]);
        }
    }

    // Redirecione após o sucesso
    return redirect()->route('questionarios.index');
}


}