@extends('layouts.app') <!-- Usa o layout base da aplicação -->

@section('content')
<div class="container">
    <!-- Título do questionário -->
    <h1>{{ $questionario->titulo }}</h1>

    <!-- Formulário para responder o questionário -->
    <form action="{{ route('questionarios.salvarResposta', $questionario) }}" method="POST">
        @csrf <!-- Token de segurança obrigatório no Laravel -->

        <!-- Campo para o nome do usuário -->
        <div class="form-group">
            <label for="nome">Seu Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <!-- Exibição das perguntas e respostas -->
        @foreach ($questionario->perguntas as $pergunta)
            <div class="mb-4">
                <h5>{{ $pergunta->texto }}</h5> <!-- Texto da pergunta -->

                @foreach ($pergunta->respostas as $resposta)
                    <div>
                        <label>
                            <!-- Botão de rádio para selecionar a resposta -->
                            <!-- <input type="radio" name="respostas[{{ $pergunta->id }}]" value="{{ $resposta->id }}" required>-->
                            <input type="number" name="respostas[{{ $resposta->id }}]" min="0" max="4" value="0" class="form-control" style="width: 80px; display: inline-block;">
                            {{ $resposta->texto }} <!-- Texto da resposta -->
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <!-- Botão para enviar as respostas -->
        <button type="submit" class="btn btn-primary">Enviar Respostas</button>
    </form>
</div>
@endsection