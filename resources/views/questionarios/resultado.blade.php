@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultado do Questionário: {{ $questionario->titulo}}</h1>

    <div class="alert alert-info">
        Obrigado, <strong>{{ $usuario->nome }}</strong>!
    <!-- Exibição da pontuação -->
        Você conseguiu <strong>{{ $resultado->pontuacao}} ponto(s)</strong> em <strong>{{ $questionario->perguntas->count() }} pergunta(s)</strong>.
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Respostas:</h4>
            @foreach ($questionario->perguntas as $pergunta)
                <div class="mb-4">
                    <h5>{{ $pergunta->texto }}</h5>

                    @foreach ($pergunta->respostas as $resposta)
                        <div 
                            class="p-2 {{ $resposta->correta ? 'bg-success text-white' : '' }}" 
                            style="border: 1px solid #ccc; border-radius: 5px; margin-bottom: 5px;">
                            {{ $resposta->texto }}

                            @if ($resposta->correta)
                                <strong>(Correta)</strong>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    
    <a href="{{ route('questionarios.index') }}" class="btn btn-primary mt-3">Voltar para Questionários</a>
</div>
@endsection
