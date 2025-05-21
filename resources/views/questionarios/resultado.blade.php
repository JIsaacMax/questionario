@extends('layouts.app')

@section('title', 'Resultado')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">Resultado do Questionário</h1>

    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
        <p class="text-gray-800 dark:text-gray-100">
            Obrigado, <strong>{{ $usuario->nome }}</strong>!
            Você marcou <strong>{{ $resultado->pontuacao }}</strong> ponto(s)
            em <strong>{{ $questionario->perguntas->count() }}</strong> pergunta(s).
        </p>
    </div>

    @foreach ($questionario->perguntas as $pergunta)
    <div class="border p-4 rounded-lg mb-4">
        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $pergunta->texto }}</p>
        <ul class="mt-2 space-y-2">
            @foreach ($pergunta->respostas as $resposta)
            <li class="flex items-center space-x-2">
                @if ($resposta->correta)
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                @else
                <span class="inline-block w-3 h-3 bg-gray-300 rounded-full"></span>
                @endif
                <span class="{{ $resposta->correta ? 'text-green-800' : 'text-gray-700 dark:text-gray-300' }}">
                    {{ $resposta->texto }}
                    @if ($resposta->correta)
                    <strong>(Correta)</strong>
                    @endif
                </span>
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach

    <div class="mt-6">
        <a href="{{ route('questionarios.index') }}"
            class="px-4 py-2 bg-gray-200 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 transition">
            Voltar
        </a>
    </div>
</div>
@endsection