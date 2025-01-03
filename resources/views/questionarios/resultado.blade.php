@extends('layouts.app') <!-- Usa o layout base da aplicação -->

@section('content')
<div class="container">
    <!-- Título da página -->
    <h1>Resultado</h1>

    <!-- Mensagem de agradecimento -->
    <p>Obrigado, {{ $usuario->nome }}!</p>

    <!-- Exibição da pontuação -->
    <p>Você acertou {{ $resultado->pontuacao}} de {{ $questionario->perguntas->count() }} perguntas.</p>

    <!-- Botão para voltar à lista de questionários -->
    <a href="{{ route('questionarios.index') }}" class="btn btn-secondary">Voltar aos Questionários</a>
</div>
@endsection
