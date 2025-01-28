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
        $data = $request->validate(['titulo' => 'required|string|max:255']);
        $questionario = Questionario::create($data);

        foreach ($request->perguntas as $perguntaData) {
            // Cria pergunta
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

                // Cria resposta
                $pergunta->respostas()->create([
                    'texto' => $respostaData['texto'],
                    'correta' => $isCorreta,
                ]);
            }
    }

        return redirect()->route('questionarios.index');
    }

    public function responder(Questionario $questionario)
    {
        return view('questionarios.responder', compact('questionario'));
    }

    public function salvarResposta(Request $request, Questionario $questionario)
    {
        $request->validate(['nome' => 'required|string|max:255']);
        // Salva o usuário
        $usuario = Usuario::firstOrCreate(['nome' => $request->nome]);
        
        // Contém os IDs das respostas e os pontos atribuídos
        $respostasUsuario = $request->input('respostas'); 

        $pontosAtribuidos = 0;
        $pontuacaoFinal = 0;

        foreach ($questionario->perguntas as $pergunta) {
            foreach ($pergunta->respostas as $resposta) {
                if (isset($respostasUsuario[$resposta->id])) {
                    $pontosAtribuidos = (int)$respostasUsuario[$resposta->id];

                    // Se a resposta for correta, acumula a pontuação atribuída
                    if ($resposta->correta) {
                        $pontuacaoFinal += $pontosAtribuidos;
                    }
                }
            }
        }

        Resultado::create([
            'usuario_id' => $usuario->id,
            'questionario_id' => $questionario->id,
            'pontuacao' => $pontuacaoFinal,
        ]);

        return redirect()->route('questionarios.resultado', ['usuario' => $usuario->id, 'questionario' => $questionario->id]);
    }

    public function resultado(Request $request, $usuarioId, $questionarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $questionario = Questionario::findOrFail($questionarioId);

        // Buscar o último resultado do usuário para este questionário
        $resultado = Resultado::where('usuario_id', $usuario->id)
            ->where('questionario_id', $questionario->id)
            ->latest() // Ordena pelos mais recentes
            ->first(); // Pega apenas o primeiro

        if (!$resultado) {
            return redirect()->route('questionarios.index')->withErrors(['error' => 'Nenhum resultado encontrado para este questionário.']);
        }

        return view('questionarios.resultado', [
            'usuario' => $usuario,
            'questionario' => $questionario,
            'resultado' => $resultado,
        ]);
    }

    public function resultados()
    {
        $questionarios = Questionario::all();
        return view('resultados.selecionar', compact('questionarios'));
    }

    public function resultadosPorQuestionario($id)
    {
        $questionario = Questionario::with('resultados.usuario')->findOrFail($id);
        return view('resultados.index', compact('questionario'));
    }

    public function destroy($id)
    {
        $questionario = Questionario::findOrFail($id);
        $questionario->delete();
        return redirect()->route('questionarios.index')->with('success', 'Questionário excluído com sucesso!');
    }

    public function apagarResultados($id)
    {
        $questionario = Questionario::findOrFail($id);
        $questionario->resultados()->delete();
        return redirect()->route('questionarios.index')->with('success', 'Resultados do questionário "' . $questionario->titulo . '" foram apagados com sucesso.');
    }

    
    public function show($id)
    {
        $questionario = Questionario::with('perguntas.respostas')->findOrFail($id);
        return view('questionarios.show', compact('questionario'));
    }

    public function edit(Questionario $questionario)
    {
        $questionario = Questionario::with('perguntas.respostas')->findOrFail($questionario->id);
        return view('questionarios.edit', compact('questionario'));
    }

    public function update(Request $request, Questionario $questionario)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'perguntas' => 'nullable|array',
            'perguntas.*.id' => 'nullable|exists:perguntas,id',
            'perguntas.*.texto' => 'required|string|max:255',
            'perguntas.*.respostas' => 'nullable|array',
            'perguntas.*.respostas.*.id' => 'nullable|exists:respostas,id',
            'perguntas.*.respostas.*.texto' => 'required|string|max:255',
            'perguntas.*.correta' => 'nullable|integer',
        ]);

        // Atualizar o título do questionário
        $questionario->update(['titulo' => $data['titulo']]);

        // Iterar pelas perguntas
        foreach ($data['perguntas'] as $perguntaData) {
            $pergunta = Pergunta::updateOrCreate(
                ['id' => $perguntaData['id'] ?? null, 'questionario_id' => $questionario->id],
                ['texto' => $perguntaData['texto']]
            );

            $corretas = 0;

            // Iterar pelas respostas
            foreach ($perguntaData['respostas'] as $respostaData) {
                $resposta = Resposta::updateOrCreate(
                    ['id' => $respostaData['id'] ?? null, 'pergunta_id' => $pergunta->id],
                    ['texto' => $respostaData['texto']]
                );

                // Atualizar a resposta correta
                $isCorreta = isset($perguntaData['correta']) && $perguntaData['correta'] == $resposta->id;
                if ($isCorreta) {
                    $corretas++;
                    $resposta->update(['correta' => true]);
                } else {
                    $resposta->update(['correta' => false]);
                }
            }

            if ($corretas > 1) {
                return redirect()->back()->withErrors([
                    'error' => "Cada pergunta pode ter no máximo uma resposta correta.",
                ]);
            }
        }
        return redirect()->route('questionarios.index')->with('success', 'Questionário atualizado com sucesso!');
    }
}