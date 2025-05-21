@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Lista de Questionários</h1>
        <a href="{{ route('questionarios.create') }}"
            class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700 transition">
            Criar Novo
        </a>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 dark:bg-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-50 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-50 uppercase">Título</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-50 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200">
                @foreach ($questionarios as $questionario)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $questionario->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $questionario->titulo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center space-x-1">
                        <a href="{{ route('questionarios.show', $questionario) }}"
                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition text-xs">
                            Ver
                        </a>
                        <a href="{{ route('resultados.por_questionario', $questionario) }}"
                            class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded hover:bg-indigo-200 transition text-xs">
                            Resultados
                        </a>
                        <a href="{{ route('responder.questionario', $questionario) }}"
                            class="px-2 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200 transition text-xs">
                            Responder
                        </a>
                        <a href="{{ route('questionarios.edit', $questionario) }}"
                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 transition text-xs">
                            Editar
                        </a>
                        <form action="{{ route('questionarios.destroy', $questionario) }}"
                            method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-2 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 transition text-xs">
                                Excluir
                            </button>
                        </form>
                        <button type="button"
                            data-link="{{ route('questionarios.responder', $questionario) }}"
                            class="copy-link px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded hover:bg-gray-200 transition text-xs">
                            Copiar Link
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.copy-link').forEach(button => {
        button.addEventListener('click', function() {
            const link = this.getAttribute('data-link');
            navigator.clipboard.writeText(link)
                .then(() => alert('Link copiado: ' + link))
                .catch(err => console.error('Erro ao copiar:', err));
        });
    });
</script>
@endsection