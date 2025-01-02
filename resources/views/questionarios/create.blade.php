<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Questionário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <h1>Criar Questionário</h1>
    <form method="POST" action="{{ route('questionarios.store') }}">
        @csrf
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required>

        <div id="perguntas">
            <h3>Perguntas</h3>
            <button type="button" onclick="adicionarPergunta()">Adicionar Pergunta</button>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <script>
        function adicionarPergunta() {
            const perguntasDiv = document.getElementById('perguntas');
            const index = perguntasDiv.children.length;

            const novaPergunta = `
                <div>
                    <label>Pergunta:</label>
                    <input type="text" name="perguntas[${index}][texto]" required>
                    <div>
                        <h4>Respostas</h4>
                        <button type="button" onclick="adicionarResposta(${index})">Adicionar Resposta</button>
                        <div id="respostas-${index}"></div>
                    </div>
                </div>
            `;
            perguntasDiv.insertAdjacentHTML('beforeend', novaPergunta);
        }

        function adicionarResposta(perguntaIndex) {
            const respostasDiv = document.getElementById(`respostas-${perguntaIndex}`);
            const index = respostasDiv.children.length;

            const novaResposta = `
                <div>
                    <label>Resposta:</label>
                    <input type="text" name="perguntas[${perguntaIndex}][respostas][${index}][texto]" required>
                    <label>Correta:</label>
                    <input type="checkbox" name="perguntas[${perguntaIndex}][respostas][${index}][correta]">
                </div>
            `;
            respostasDiv.insertAdjacentHTML('beforeend', novaResposta);
        }
    </script>
</body>
</html>
