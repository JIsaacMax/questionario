@extends('layouts.app') <!-- Usa o layout base da aplicação -->

@section('content')
<div class="container">

    <!-- Título do questionário -->
    <h1>{{ $questionario->titulo }}</h1>

    <!-- Formulário para responder o questionário -->
    <form id="responderForm" action="{{ route('questionarios.salvarResposta', $questionario) }}" method="POST">
        @csrf

        <!-- Campo para o nome do usuário -->
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <!-- Exibição das perguntas e respostas -->
        @foreach ($questionario->perguntas as $pergunta)
            <div class="pergunta mb-4" data-titulo="{{ $pergunta->texto }}">
                <h5>{{ $pergunta->texto }}</h5> <!-- Texto da pergunta -->

                @foreach ($pergunta->respostas as $resposta)
                    <div class="resposta">
                        <label>
                            <input type="number" name="respostas[{{ $resposta->id }}]" min="0" max="4" value="0" class="form-control pontos-input" style="width: 80px; display: inline-block;">
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

<!-- Script para validar os pontos -->
<script>
    document.getElementById('responderForm').addEventListener('submit', function (e) {
        let perguntas = document.querySelectorAll('.pergunta');
        let isValid = true;

        perguntas.forEach(pergunta => {
            let totalPontos = 0;
            let inputs = pergunta.querySelectorAll('.pontos-input');

            inputs.forEach(input => {
                let valor = parseInt(input.value) || 0; // Converte para número ou usa 0
                totalPontos += valor;
            });

            if (totalPontos > 4) {
                isValid = false;
                alert(`A soma dos pontos para a pergunta "${pergunta.dataset.titulo}" não pode ultrapassar 4!`);
            }
        });

        if (!isValid) {
            e.preventDefault(); // Impede o envio do formulário
        }
    });
</script>
@endsection