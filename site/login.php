<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>🔐 Login</h1>
            <p>Acesse sua conta para se candidatar</p>
            
            <?php
            if(isset($_GET['erro'])){
                if($_GET['erro'] == 'email'){
                    echo '<div class="alert alert-error">E-mail não cadastrado!</div>';
                }
                if($_GET['erro'] == 'senha'){
                    echo '<div class="alert alert-error">Senha incorreta!</div>';
                }
            }
            if(isset($_GET['sucesso'])){
                if($_GET['sucesso'] == 'cadastro'){
                    echo '<div class="alert alert-success">Cadastro realizado com sucesso! Faça login.</div>';
                }
            }
            ?>
            
            <form action="loginOk.php" method="post">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" required/>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" required/>
                </div>
                <div>
                    <button type="submit" class="btn">Entrar</button>
                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
            
            <p style="margin-top: 20px; text-align: center;">
                Não tem uma conta? <a href="cadastro.php" style="color: #504988ff; font-weight: 600;">Cadastre-se</a>
            </p>
        </div>
    </div>
</body>
</html>