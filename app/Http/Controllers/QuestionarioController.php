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

        // Salva o resultado no banco de dados
        Resultado::create([
            'usuario_id' => $usuario->id,
            'questionario_id' => $questionario->id,
            'pontuacao' => $pontuacaoFinal,
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

    public function resultados()
    {
        // Busca todos os questionários
        $questionarios = Questionario::all();

        // Retorna a view com os questionários
        return view('resultados.selecionar', compact('questionarios'));
    }

    public function resultadosPorQuestionario($id)
    {
        // Busca o questionário específico
        $questionario = Questionario::with('resultados.usuario')->findOrFail($id);

        // Retorna a view com os resultados do questionário
        return view('resultados.index', compact('questionario'));
    }

    public function apagarQuestionario($id)
    {
        // Encontre o questionário pelo ID
        $questionario = Questionario::findOrFail($id);

        // Delete o questionário e seus relacionamentos
        $questionario->delete();

        // Redirecione com uma mensagem de sucesso
        return redirect()->route('questionarios.index')->with('success', 'Questionário excluído com sucesso!');
    }

    public function apagarResultados($id)
    {
        // Encontre o questionário
        $questionario = Questionario::findOrFail($id);

        // Apague os resultados relacionados ao questionário
        $questionario->resultados()->delete();

        // Redirecione de volta para a página de seleção com uma mensagem de sucesso
        return redirect()->route('questionarios.index')->with('success', 'Resultados do questionário "' . $questionario->titulo . '" foram apagados com sucesso.');
    }

    public function show($id)
    {
        // Encontre o questionário pelo ID
        $questionario = Questionario::with('perguntas.respostas')->findOrFail($id);

        // Retorne a view para exibir o questionário
        return view('questionarios.show', compact('questionario'));
    }

    public function edit($id)
    {
        // Busca o questionário pelo ID com perguntas e respostas
        $questionario = Questionario::with('perguntas.respostas')->findOrFail($id);

        // Retorna a view de edição
        return view('questionarios.edit', compact('questionario'));
    }

    public function update(Request $request, $id)
    {
        $questionario = Questionario::findOrFail($id);

        // Valida e atualiza o título do questionário
        $data = $request->validate(['titulo' => 'required|string|max:255']);
        $questionario->update($data);

        // Atualiza ou adiciona perguntas e respostas
        foreach ($request->perguntas as $perguntaData) {
            if (isset($perguntaData['id'])) {
                // Atualiza perguntas existentes
                $pergunta = Pergunta::findOrFail($perguntaData['id']);
                $pergunta->update(['texto' => $perguntaData['texto']]);

                foreach ($perguntaData['respostas'] as $respostaData) {
                    if (isset($respostaData['id'])) {
                        // Atualiza respostas existentes
                        $resposta = Resposta::findOrFail($respostaData['id']);
                        $resposta->update([
                            'texto' => $respostaData['texto'],
                            'correta' => $respostaData['correta'] ?? false,
                        ]);
                    } else {
                        // Adiciona novas respostas
                        $pergunta->respostas()->create([
                            'texto' => $respostaData['texto'],
                            'correta' => $respostaData['correta'] ?? false,
                        ]);
                    }
                }
            } else {
                // Adiciona novas perguntas com respostas
                $novaPergunta = $questionario->perguntas()->create(['texto' => $perguntaData['texto']]);

                foreach ($perguntaData['respostas'] as $respostaData) {
                    $novaPergunta->respostas()->create([
                        'texto' => $respostaData['texto'],
                        'correta' => $respostaData['correta'] ?? false,
                    ]);
                }
            }
        }

        // Redireciona com sucesso
        return redirect()->route('questionarios.index')->with('success', 'Questionário atualizado com sucesso!');
    }
}