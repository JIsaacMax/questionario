@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Questionários</h1>

    <a href="{{ route('questionarios.create') }}" class="btn btn-primary mb-3">Criar Novo Questionário</a>

    <!-- Tabela de questionários -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questionarios as $questionario)
                <tr>
                    <td>{{ $questionario->id }}</td>
                    <td>{{ $questionario->titulo }}</td>
                    <td>
                        <a href="{{ route('questionarios.show', $questionario->id) }}" class="btn btn-info btn-sm">Visualizar</a>
                        <a href="{{ route('responder.questionario', $questionario->id) }}" class="btn btn-success btn-sm">Responder</a>
                        <form action="{{ route('questionarios.destroy', $questionario->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
