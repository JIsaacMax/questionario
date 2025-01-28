@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Questionário: {{ $questionario->titulo }}</h1>
    <form action="{{ route('questionarios.atualizar', $questionario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="titulo">Título do Questionário:</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="{{ $questionario->titulo }}" required>
        </div>

        <div id="perguntas-container">
            @foreach ($questionario->perguntas as $pergunta)
                <div class="pergunta mb-4" data-index="{{ $loop->index }}">
                    <h5>Pergunta {{ $loop->iteration }}</h5>
                    <input type="hidden" name="perguntas[{{ $loop->index }}][id]" value="{{ $pergunta->id }}">
                    <input type="text" name="perguntas[{{ $loop->index }}][texto]" class="form-control mb-2" value="{{ $pergunta->texto }}" required>

                    <div class="respostas-container">
                        @foreach ($pergunta->respostas as $resposta)
                            <div class="resposta">
                                <h5>Resposta {{ $loop->iteration }}</h5>
                                <input type="hidden" name="perguntas[{{ $loop->parent->index }}][respostas][{{ $loop->index }}][id]" value="{{ $resposta->id }}">
                                <input type="text" name="perguntas[{{ $loop->parent->index }}][respostas][{{ $loop->index }}][texto]" class="form-control mb-1" value="{{ $resposta->texto }}" required>
                                <label>
                                    <input type="radio" name="perguntas[{{ $loop->parent->index }}][correta]" value="{{ $resposta->id }}" {{ $resposta->correta ? 'checked' : '' }}>
                                    Resposta Correta
                                </label>
                            </div>
                        @endforeach
                    </div>

                    
                    <button type="button" class="btn btn-secondary btn-sm add-resposta" data-pergunta-index="{{ $loop->index }}">Adicionar Resposta</button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-pergunta" class="btn btn-primary bt-sm">Adicionar Pergunta</button>
        <button type="submit" class="btn btn-success bt-sm">Salvar Alterações</button>
        <a href="{{ route('questionarios.index') }}" class="btn btn-secondary bt-sm">Voltar aos Questionários</a>
    </form>
</div>


<script>
    document.getElementById('add-pergunta').addEventListener('click', function () {
        const perguntasContainer = document.getElementById('perguntas-container');
        const perguntaIndex = perguntasContainer.children.length;

        const novaPergunta = `
            <div class="pergunta mb-4" data-index="${perguntaIndex}">
                <h5>Pergunta ${perguntaIndex + 1}</h5>
                <input type="text" name="perguntas[${perguntaIndex}][texto]" class="form-control mb-2" placeholder="Texto da pergunta" required>
                <div class="respostas-container"></div>
                <button type="button" class="btn btn-secondary btn-sm add-resposta" data-pergunta-index="${perguntaIndex}">Adicionar Resposta</button>
            </div>
        `;

        perguntasContainer.insertAdjacentHTML('beforeend', novaPergunta);

        const addRespostaButton = perguntasContainer.querySelector(`.pergunta[data-index="${perguntaIndex}"] .add-resposta`);
        addRespostaButton.addEventListener('click', function () {
            adicionarResposta(perguntaIndex);
        });
    });

    function adicionarResposta(perguntaIndex) {
        const perguntaElement = document.querySelector(`.pergunta[data-index="${perguntaIndex}"]`);
        const respostasContainer = perguntaElement.querySelector('.respostas-container');
        const respostaIndex = respostasContainer.children.length;

        const novaResposta = `
            <div class="resposta mb-2">
                <h5>Resposta ${respostaIndex + 1}</h5>
                <input type="text" name="perguntas[${perguntaIndex}][respostas][${respostaIndex}][texto]" class="form-control mb-1" placeholder="Texto da resposta" required>
                <label>
                    <input type="radio" name="perguntas[${perguntaIndex}][correta]" value="${respostaIndex}">
                    Resposta Correta
                </label>
            </div>
        `;

        respostasContainer.insertAdjacentHTML('beforeend', novaResposta);
    }

    document.querySelectorAll('.add-resposta').forEach(button => {
        button.addEventListener('click', function () {
            const perguntaIndex = this.getAttribute('data-pergunta-index');
            adicionarResposta(perguntaIndex);
        });
    });
</script>
@endsection
