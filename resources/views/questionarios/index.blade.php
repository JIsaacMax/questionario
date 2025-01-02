<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <h1>Questionários</h1>
    <a href="{{ route('questionarios.create') }}">Novo Questionário</a>
    <ul>
        @foreach ($questionarios as $questionario)
            <li>
                <h2>{{ $questionario->titulo }}</h2>
                <ul>
                    @foreach ($questionario->perguntas as $pergunta)
                        <li>
                            {{ $pergunta->texto }}
                            <ul>
                                @foreach ($pergunta->respostas as $resposta)
                                    <li>{{ $resposta->texto }} ({{ $resposta->correta ? 'Correta' : 'Errada' }})</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</body>
</html>
