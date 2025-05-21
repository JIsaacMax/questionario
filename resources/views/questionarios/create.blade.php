@extends('layouts.app')

@section('title', 'Criar Questionário')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-6">Criar Questionário</h1>

    <form action="{{ route('questionarios.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título do Questionário</label>
            <input type="text" id="titulo" name="titulo"
                class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-400"
                required>
        </div>

        <div id="perguntas-container" class="space-y-6"></div>

        <div class="flex space-x-2">
            <button type="button" id="add-pergunta"
                class="px-4 py-2 bg-gray-200 text-gray-800 dark:text-gray-600 rounded-lg hover:bg-gray-300 transition">
                + Adicionar Pergunta
            </button>
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Salvar Questionário
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let perguntaCount = 0;

        const perguntasContainer = document.getElementById('perguntas-container');
        const addPerguntaBtn = document.getElementById('add-pergunta');

        addPerguntaBtn.addEventListener('click', () => {
            perguntaCount++;
            const divPergunta = document.createElement('div');
            divPergunta.className = 'space-y-4 border p-4 rounded-lg';

            divPergunta.innerHTML = `
                <div class="flex justify-between items-center">
                  <h2 class="text-lg font-medium">Pergunta ${perguntaCount}</h2>
                  <button type="button" data-index="${perguntaCount}" class="remove-pergunta text-red-500 hover:text-red-700">&times;</button>
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">Texto</label>
                  <input type="text" name="perguntas[${perguntaCount}][texto]" class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"required>
                </div>
                <div id="respostas-${perguntaCount}" class="space-y-3"></div>
                <button type="button" data-pergunta-index="${perguntaCount}" class="add-resposta px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded hover:bg-gray-200 transition">
                  + Resposta
                </button>
            `;

            perguntasContainer.appendChild(divPergunta);

            // remover pergunta
            divPergunta.querySelector('.remove-pergunta')
                .addEventListener('click', () => divPergunta.remove());

            // adicionar resposta
            divPergunta.querySelector('.add-resposta')
                .addEventListener('click', function() {
                    const idx = this.dataset.perguntaIndex;
                    const cont = document.getElementById(`respostas-${idx}`);
                    const respCount = cont.children.length + 1;

                    const divResp = document.createElement('div');
                    divResp.className = 'flex items-center space-x-2';

                    divResp.innerHTML = `
                      <input type="text" name="perguntas[${idx}][respostas][${respCount}][texto]"
                             placeholder="Texto da resposta"
                             class="flex-1 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                             required>
                      <label class="flex items-center space-x-1 text-sm text-gray-700 dark:text-gray-300">
                        <input type="radio" name="perguntas[${idx}][correta]" value="${respCount}" class="text-indigo-600">
                        <span>Correta</span>
                      </label>
                      <button type="button" class="remove-resposta text-red-500 hover:text-red-700">&times;</button>
                    `;

                    cont.appendChild(divResp);

                    divResp.querySelector('.remove-resposta')
                        .addEventListener('click', () => divResp.remove());
                });
        });
    });
</script>
@endsection