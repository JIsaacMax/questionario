@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Questionário</h1>
    <p><strong>Título:</strong> {{ $questionario->titulo }}</p>

    <h3>Perguntas:</h3>
    @foreach ($questionario->perguntas as $pergunta)
        <div>
            <p><strong>Pergunta:</strong> {{ $pergunta->texto }}</p>
            <ul>
                @foreach ($pergunta->respostas as $resposta)
                    <li>{{ $resposta->texto }} @if($resposta->correta) (Correta) @endif</li>
                @endforeach
            </ul>
        </div>
    @endforeach
    
    <a href="{{ route('questionarios.index') }}" class="btn btn-primary mt-3">Voltar para Questionários</a>
</div>
@endsection
