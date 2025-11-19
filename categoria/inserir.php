<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Categoria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nova Categoria</h1>
        </div>
        
        <div class="content">
            <form action="inserirOk.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome da Categoria:</label>
                    <input type="text" name="nome" id="nome" required placeholder="Ex: Tecnologia"/>
                </div>
                <div>
                    <button type="submit" class="btn">Cadastrar</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>