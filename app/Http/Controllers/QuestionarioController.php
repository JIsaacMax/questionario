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
    $usuario = Usuario::create(['nome' => $request->nome]);
    $resultado = Resultado::create(['pontuacao' => $request->pontuacao]);

    // Inicializar pontuação
    $pontuacao = 0;

    // Processar as respostas
    foreach ($questionario->perguntas as $pergunta) {
        $respostaSelecionada = $request->input("respostas.{$pergunta->id}");

        if ($respostaSelecionada) {
            $resposta = Resposta::find($respostaSelecionada);
            if ($resposta && $resposta->correta) {
                $pontuacao++;
            }
        }
    }

    // Salvar a pontuação do usuário
    $resultado->pontuacao = $pontuacao;
    $resultado->save();

    // Redirecionar para a página de resultado
    return redirect()->route('questionarios.resultado', ['usuario' => $usuario, 'questionario' => $questionario]);
    }

    public function resultado(Usuario $usuario, Questionario $questionario, Resultado $resultado)
    {
        // Obter a pontuação do usuário
        $pontuacao = $resultado->pontuacao;

        // Retornar a view do resultado com os dados necessários
        return view('questionarios.resultado', compact('usuario', 'pontuacao', 'questionario'));
    }

}