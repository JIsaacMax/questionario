@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Questionário</h1>

    <form action="{{ route('questionarios.update', $questionario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título do Questionário</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="{{ $questionario->titulo }}" required>
        </div>

        <div id="perguntas-container">
            @foreach ($questionario->perguntas as $index => $pergunta)
                <div class="pergunta mb-4">
                    <label for="perguntas[{{ $index }}][texto]" class="form-label">Pergunta</label>
                    <input type="text" name="perguntas[{{ $index }}][texto]" class="form-control" value="{{ $pergunta->texto }}" required>
                    <input type="hidden" name="perguntas[{{ $index }}][id]" value="{{ $pergunta->id }}">

                    <div class="respostas-container mt-3">
                        @foreach ($pergunta->respostas as $respostaIndex => $resposta)
                            <div class="resposta mb-2">
                                <input type="text" name="perguntas[{{ $index }}][respostas][{{ $respostaIndex }}][texto]" class="form-control" value="{{ $resposta->texto }}" required>
                                <input type="hidden" name="perguntas[{{ $index }}][respostas][{{ $respostaIndex }}][id]" value="{{ $resposta->id }}">
                                <input type="radio" name="perguntas[{{ $index }}][respostas][{{ $respostaIndex }}][correta]" value="${respostaCount}" {{ $resposta->correta ? 'checked' : '' }}> Correta
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary add-resposta-btn mt-2">Adicionar Resposta</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-primary bt-sm">Adicionar Pergunta</button>
        <button type="submit" class="btn btn-success bt-sm">Salvar Alterações</button>
        <a href="{{ route('questionarios.index') }}" class="btn btn-primary bt-sm">Voltar à Lista de Questionários</a>
    </form>
</div>

<script>
    // Scripts para adicionar perguntas e respostas dinamicamente
</script>
@endsection