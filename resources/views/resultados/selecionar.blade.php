@extends('layouts.app')

@section('title', 'Selecionar Questionário')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-white dark:bg-gray-900 rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">Selecionar Questionário</h1>

    <ul class="space-y-2">
        @foreach ($questionarios as $questionario)
        <li>
            <a href="{{ route('resultados.por_questionario', $questionario->id) }}"
                class="block px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 transition">
                {{ $questionario->titulo }}
            </a>
        </li>
        @endforeach
    </ul>

    <div class="mt-6">
        <a href="{{ route('questionarios.index') }}"
            class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Voltar à Lista de Questionários
        </a>
    </div>
</div>
@endsection