@extends('layouts.app')

@section('title', 'Resultados do Questionário')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">
        Resultados do Questionário: {{ $questionario->titulo }}
    </h1>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 dark:bg-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-50 uppercase">Usuário</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-50 uppercase">Pontuação</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-50 uppercase">Data</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200">
                @forelse ($questionario->resultados as $resultado)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $resultado->usuario->nome }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $resultado->pontuacao }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $resultado->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-50">
                        Nenhum resultado encontrado para este questionário.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex space-x-2">
        <a href="{{ route('questionarios.index') }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Voltar à Lista
        </a>
        <form action="{{ route('resultados.apagar', $questionario->id) }}"
            method="POST"
            class="inline"
            onsubmit="return confirm('Tem certeza que deseja apagar todos os resultados deste questionário?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                Apagar Resultados
            </button>
        </form>
    </div>
</div>
@endsection