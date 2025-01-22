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
                        <a href="{{ route('questionarios.show', $questionario->id) }}" class="btn btn-info btn-sm">Visualizar Questionário</a>
                        <a href="{{ route('resultados.por_questionario', $questionario->id) }}" class="btn btn-primary btn-sm">Visualizar Resultados</a>
                        <a href="{{ route('responder.questionario', $questionario->id) }}" class="btn btn-success btn-sm">Responder</a>
                        <a href="{{ route('questionarios.edit', $questionario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('questionarios.destroy', $questionario->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                        <!-- Botão para gerar link -->
                        <button type="button" class="btn btn-info btn-sm copy-link" data-link="{{ route('questionarios.responder', $questionario) }}"> Gerar Link </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.copy-link').forEach(button => {
        button.addEventListener('click', function () {
            const link = this.getAttribute('data-link');
            navigator.clipboard.writeText(link).then(() => {
                alert('Link copiado para a área de transferência: ' + link);
            }).catch(err => {
                console.error('Erro ao copiar o link: ', err);
            });
        });
    });
</script>
@endsection
