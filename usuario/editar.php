<?php

include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";

$idusuario = $_GET["id"];
$objUsuarioDAO = new UsuarioDAO();
$retorno = $objUsuario->buscarPorId($idusuario);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="editarOk.php" method="POST">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?=$retorno["nome"]?>">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?=$retorno["email"]?>">
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" value="<?=$retorno["senha"]?>">
            <input type="hidden" name="id" id="senha" value="<?=$retorno["id"]?>">

        </div>
        <div>
            <button type="submit">Enviar</button>
        </div>
        
    </form>
</body>
</html>