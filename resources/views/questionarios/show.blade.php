@extends('layouts.app')

@section('title', 'Detalhes do Questionário')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">Detalhes do Questionário</h1>

    <div class="space-y-4">
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-300">Título:</span>
            <span class="text-gray-900">{{ $questionario->titulo }}</span>
        </div>

        <div>
            <h2 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Perguntas:</h2>
            <ul class="space-y-4">
                @foreach ($questionario->perguntas as $pergunta)
                <li class="border p-4 rounded-lg">
                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $pergunta->texto }}</p>
                    <ul class="mt-2 space-y-1">
                        @foreach ($pergunta->respostas as $resposta)
                        <li class="flex items-center space-x-2">
                            @if($resposta->correta)
                            <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                            @else
                            <span class="inline-block w-2 h-2 bg-gray-300 rounded-full"></span>
                            @endif
                            <span class="text-gray-700 dark:text-gray-300">{{ $resposta->texto }}</span>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-6 flex space-x-2">
        <a href="{{ route('questionarios.index') }}"
            class="px-4 py-2 bg-gray-200 text-gray-800 dark:text-gray-600 rounded-lg hover:bg-gray-300 transition">
            Voltar
        </a>
        <a href="{{ route('questionarios.edit', $questionario) }}"
            class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
            Editar
        </a>
    </div>
</div>
@endsection