<?php

namespace App\Http\Controllers;

use App\Models\Questionario;
use App\Models\Pergunta;
use App\Models\Resposta;
use App\Models\Resultado;
use App\Models\Usuario;
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

    public function responder(Questionario $questionario)
    {
        return view('questionarios.responder', compact('questionario'));
    }

    public function salvarResposta(Request $request, Questionario $questionario)
    {
    // Validação do nome do usuário
    $request->validate(['nome' => 'required|string|max:255']);

    // Salvar o usuário no banco de dados
    $usuario = Usuario::firstOrCreate(['nome' => $request->nome]);

    // Inicializar pontuação
    $pontuacao = 0;

    // Processar as respostas
    foreach ($questionario->perguntas as $pergunta) {
        $respostaCorreta = $pergunta->respostas()->where('correta', true)->first();
        if ($respostaCorreta && $request->respostas[$pergunta->id] == $respostaCorreta->id) {
            $pontuacao++;
        }
    }

    // Salvar o resultado
    Resultado::create([
        'usuario_id' => $usuario->id,
        'questionario_id' => $questionario->id,
        'pontuacao' => $pontuacao,
    ]);


    return redirect()->route('questionarios.resultado', ['usuario' => $usuario->id, 'questionario' => $questionario->id]);
    }

    public function resultado(Request $request, $usuarioId, $questionarioId)
    {
        // Buscar o usuário
        $usuario = Usuario::findOrFail($usuarioId);

        // Buscar o questionário
        $questionario = Questionario::findOrFail($questionarioId);

        // Buscar o último resultado do usuário para este questionário
        $resultado = Resultado::where('usuario_id', $usuario->id)
            ->where('questionario_id', $questionario->id)
            ->latest() // Ordena pelos mais recentes
            ->first(); // Pega apenas o primeiro

        // Caso não haja resultado, redirecione ou mostre uma mensagem
        if (!$resultado) {
            return redirect()->route('questionarios.index')->withErrors(['error' => 'Nenhum resultado encontrado para este questionário.']);
        }

        // Retornar a view de resultado
        return view('questionarios.resultado', [
            'usuario' => $usuario,
            'questionario' => $questionario,
            'resultado' => $resultado,
        ]);
    }

    public function destroy($id)
    {
        // Encontre o questionário pelo ID
        $questionario = Questionario::findOrFail($id);

        // Delete o questionário e seus relacionamentos
        $questionario->delete();

        // Redirecione com uma mensagem de sucesso
        return redirect()->route('questionarios.index')->with('success', 'Questionário excluído com sucesso!');
    }

    public function show($id)
    {
    // Encontre o questionário pelo ID
    $questionario = Questionario::with('perguntas.respostas')->findOrFail($id);

    // Retorne a view para exibir o questionário
    return view('questionarios.show', compact('questionario'));
    }
}