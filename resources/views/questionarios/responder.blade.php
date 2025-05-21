@extends('layouts.app')

@section('title', 'Responder Questionário')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">{{ $questionario->titulo }}</h1>

    <form id="responderForm" action="{{ route('questionarios.salvarResposta', $questionario) }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seu Nome</label>
            <input type="text" id="nome" name="nome"
                class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-600 dark:bg-gray-200"
                required>
        </div>

        @foreach ($questionario->perguntas as $pergunta)
        <div class="border p-4 rounded-lg space-y-3" data-titulo="{{ $pergunta->texto }}">
            <p class="font-medium text-gray-800 dark:text-gray-100">{{ $pergunta->texto }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($pergunta->respostas as $resposta)
                <label class="flex items-center space-x-2">
                    <input type="number"
                        name="respostas[{{ $resposta->id }}]"
                        min="0" max="4" value="0"
                        class="w-16 h-10 text-center border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-600 dark:bg-gray-200">
                    <span class="text-gray-700 dark:text-gray-300">{{ $resposta->texto }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <button type="submit"
            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Enviar Respostas
        </button>
    </form>
</div>

<script>
    document.getElementById('responderForm').addEventListener('submit', function(e) {
        let isValid = true;

        document.querySelectorAll('[data-titulo]').forEach(pergunta => {
            let total = 0;
            pergunta.querySelectorAll('input[type="number"]').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            if (total > 4) {
                isValid = false;
                alert(`A soma dos pontos para "${pergunta.dataset.titulo}" não pode passar de 4!`);
            }
        });

        if (!isValid) e.preventDefault();
    });
</script>
@endsection