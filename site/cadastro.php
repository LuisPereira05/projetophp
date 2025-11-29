<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>📝 Cadastro</h1>
            <p>Crie sua conta e candidate-se às vagas</p>
            
            <form action="cadastroOk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" name="nome" id="nome" required placeholder="Digite seu nome completo"/>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" required placeholder="seu@email.com"/>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" required placeholder="Digite sua senha"/>
                </div>
                <div class="form-group">
                    <label for="linkedin">LinkedIn (URL):</label>
                    <input type="url" name="linkedin" id="linkedin" placeholder="https://linkedin.com/in/seu-perfil"/>
                </div>
                <div class="form-group">
                    <label for="imagem">Foto de Perfil:</label>
                    <input type="file" name="imagem" id="imagem" accept="image/*"/>
                </div>
                <div>
                    <button type="submit" class="btn">Cadastrar</button>
                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
            
            <p style="margin-top: 20px; text-align: center;">
                Já tem uma conta? <a href="login.php" style="color: #504988ff; font-weight: 600;">Faça login</a>
            </p>
        </div>
    </div>
</body>
</html>