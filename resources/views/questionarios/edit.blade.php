@extends('layouts.app')

@section('title', 'Editar Questionário')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-6">Editar Questionário: {{ $questionario->titulo }}</h1>

    <form action="{{ route('questionarios.atualizar', $questionario) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título do Questionário</label>
            <input type="text" id="titulo" name="titulo"
                class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                value="{{ $questionario->titulo }}" required>
        </div>

        <div id="perguntas-container" class="space-y-6">
            @foreach ($questionario->perguntas as $pergunta)
            <div class="space-y-4 border p-4 rounded-lg" data-index="{{ $loop->index }}">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-medium">Pergunta {{ $loop->iteration }}</h2>
                    <button type="button" class="remove-pergunta text-red-500 hover:text-red-700">&times;</button>
                </div>
                <input type="hidden" name="perguntas[{{ $loop->index }}][id]" value="{{ $pergunta->id }}">
                <div>
                    <label class="block text-sm font-medium mb-1">Texto</label>
                    <input type="text" name="perguntas[{{ $loop->index }}][texto]"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $pergunta->texto }}" required>
                </div>
                <div id="respostas-{{ $loop->index }}" class="space-y-3">
                    @foreach ($pergunta->respostas as $resposta)
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="perguntas[{{ $loop->parent->index }}][respostas][{{ $loop->index }}][id]" value="{{ $resposta->id }}">
                        <input type="text" name="perguntas[{{ $loop->parent->index }}][respostas][{{ $loop->index }}][texto]"
                            class="flex-1 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ $resposta->texto }}" required>
                        <label class="flex items-center space-x-1 text-sm text-gray-700 dark:text-gray-300">
                            <input type="radio" name="perguntas[{{ $loop->parent->index }}][correta]" value="{{ $resposta->id }}"
                                class="text-indigo-600" {{ $resposta->correta ? 'checked' : '' }}>
                            <span>Correta</span>
                        </label>
                        <button type="button" class="remove-resposta text-red-500 hover:text-red-700">&times;</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" data-pergunta-index="{{ $loop->index }}"
                    class="add-resposta px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded hover:bg-gray-200 transition">
                    + Resposta
                </button>
            </div>
            @endforeach
        </div>

        <div class="flex space-x-2">
            <button type="button" id="add-pergunta"
                class="px-4 py-2 bg-gray-200 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 transition">
                + Adicionar Pergunta
            </button>
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Salvar Alterações
            </button>
            <a href="{{ route('questionarios.index') }}"
                class="px-4 py-2 bg-gray-300 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-400 transition">
                Voltar
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('perguntas-container');

        // remover pergunta
        container.querySelectorAll('.remove-pergunta').forEach(btn => {
            btn.addEventListener('click', () => btn.closest('.border').remove());
        });

        // adicionar resposta
        container.querySelectorAll('.add-resposta').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = this.dataset.perguntaIndex;
                const cont = document.getElementById(`respostas-${idx}`);
                const respCount = cont.children.length + 1;

                const divResp = document.createElement('div');
                divResp.className = 'flex items-center space-x-2';
                divResp.innerHTML = `
                    <input type="text" name="perguntas[${idx}][respostas][${respCount}][texto]"
                           class="flex-1 border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Texto da resposta" required>
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

        // adicionar pergunta
        document.getElementById('add-pergunta').addEventListener('click', () => {
            const count = container.children.length;
            // criar bloco similar ao create, omitido por brevidade
        });
    });
</script>
@endsection