@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultados do Questionário: {{ $questionario->titulo }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Pontuação</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($questionario->resultados as $resultado)
                <tr>
                    <td>{{ $resultado->usuario->nome }}</td>
                    <td>{{ $resultado->pontuacao }}</td>
                    <td>{{ $resultado->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhum resultado encontrado para este questionário.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <td>
        <a href="{{ route('questionarios.index') }}" class="btn btn-primary bt-sm">Voltar à Lista de Questionários</a>
        <form action="{{ route('resultados.apagar', $questionario->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja apagar todos os resultados deste questionário?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger bt-sm">Apagar Resultados</button>
        </form>
    </td>
</div>
@endsection
