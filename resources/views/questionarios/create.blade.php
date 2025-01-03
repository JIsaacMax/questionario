@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Questionário</h1>

    <form action="{{ route('questionarios.store') }}" method="POST">
        @csrf

        <!-- Campo para o título do questionário -->
        <div class="form-group mb-3">
            <label for="titulo">Título do Questionário:</label>
            <input type="text" id="titulo" name="titulo" class="form-control" required>
        </div>

        <!-- Div onde as perguntas serão adicionadas dinamicamente -->
        <div id="perguntas-container"></div>

        <!-- Botão para adicionar perguntas -->
        <button type="button" class="btn btn-secondary mb-3" id="add-pergunta">Adicionar Pergunta</button>

        <!-- Botão para salvar o questionário -->
        <button type="submit" class="btn btn-primary">Salvar Questionário</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let perguntaCount = 0;

        document.getElementById('add-pergunta').addEventListener('click', function () {
            perguntaCount++;
            const perguntasContainer = document.getElementById('perguntas-container');

            const perguntaDiv = document.createElement('div');
            perguntaDiv.classList.add('mb-4');
            perguntaDiv.innerHTML = `
                <label>Pergunta:</label>
                <input type="text" name="perguntas[${perguntaCount}][texto]" class="form-control mb-2" required>
                
                <div class="respostas-container mb-2"></div>
                <button type="button" class="btn btn-secondary btn-sm add-resposta" data-pergunta-index="${perguntaCount}">Adicionar Resposta</button>
            `;

            perguntasContainer.appendChild(perguntaDiv);

            perguntaDiv.querySelector('.add-resposta').addEventListener('click', function () {
                const perguntaIndex = this.dataset.perguntaIndex;
                const respostasContainer = perguntaDiv.querySelector('.respostas-container');

                const respostaCount = respostasContainer.children.length;
                const respostaDiv = document.createElement('div');
                respostaDiv.classList.add('mb-2');
                respostaDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <input type="text" name="perguntas[${perguntaIndex}][respostas][${respostaCount}][texto]" class="form-control me-2" placeholder="Resposta" required>
                        <label class="me-2">Correta:</label>
                        <input type="radio" name="perguntas[${perguntaIndex}][correta]" value="${respostaCount}">
                    </div>
                `;
                respostasContainer.appendChild(respostaDiv);
            });
        });
    });
</script>
@endsection