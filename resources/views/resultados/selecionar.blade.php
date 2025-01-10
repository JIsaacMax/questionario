@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selecionar Questionário</h1>
    <ul class="list-group">
        @foreach ($questionarios as $questionario)
            <li class="list-group-item">
                <a href="{{ route('resultados.por_questionario', $questionario->id) }}">
                    {{ $questionario->titulo }}
                </a>
            </li>
        @endforeach
    </ul>
    <br>
    <a href="{{ route('questionarios.index') }}" class="btn btn-primary">Voltar à Lista de Questionários</a>
</div>
@endsection
