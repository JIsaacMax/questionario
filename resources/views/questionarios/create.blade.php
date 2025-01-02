<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Criar Questionário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .pergunta {
            margin-bottom: 20px;
        }
        .resposta {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Criar Questionário</h1>

        <!-- Exibir erros de validação -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('questionarios.store') }}">
            @csrf
            <!-- Campo para o título do questionário -->
            <div>
                <label for="titulo">Título do Questionário:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>

            <!-- Div para as perguntas -->
            <div id="perguntas">
                <h3>Perguntas</h3>
                <!-- Botão para adicionar perguntas -->
                <button type="button" onclick="adicionarPergunta()">Adicionar Pergunta</button>
            </div>

            <!-- Botão para salvar -->
            <button type="submit" style="margin-top: 20px;">Salvar Questionário</button>
        </form>
    </div>

    <script>
        // Função para adicionar uma nova pergunta
        function adicionarPergunta() {
            const perguntasDiv = document.getElementById('perguntas');
            const index = perguntasDiv.querySelectorAll('.pergunta').length;
    
            const novaPergunta = `
                <div class="pergunta">
                    <label>Pergunta:</label>
                    <input type="text" name="perguntas[${index}][texto]" required>
    
                    <div class="respostas" id="respostas-${index}">
                        <h4>Respostas</h4>
                        <!-- Botão para adicionar respostas -->
                        <button type="button" onclick="adicionarResposta(${index})">Adicionar Resposta</button>
                    </div>
                </div>
            `;
            perguntasDiv.insertAdjacentHTML('beforeend', novaPergunta);
        }
    
        // Função para adicionar uma nova resposta a uma pergunta
        function adicionarResposta(perguntaIndex) {
            const respostasDiv = document.getElementById(`respostas-${perguntaIndex}`);
            const index = respostasDiv.querySelectorAll('.resposta').length;
    
            const novaResposta = `
                <div class="resposta">
                    <label>Resposta:</label>
                    <input type="text" name="perguntas[${perguntaIndex}][respostas][${index}][texto]" required>
                    <label>
                        <input type="radio" name="perguntas[${perguntaIndex}][correta]" value="${index}">
                        Correta
                    </label>
                </div>
            `;
            respostasDiv.insertAdjacentHTML('beforeend', novaResposta);
        }
    </script>    
</body>
</html>
