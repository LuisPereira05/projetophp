<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/categoria.class.php";
include_once "../class/categoriaDAO.class.php";

$idcategoria = $_GET["id"];
$objCategoriaDAO = new CategoriaDAO();
$retorno = $objCategoriaDAO->buscarPorId($idcategoria);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../includes/sidebar.php"; ?>
    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1>Editar Categoria</h1>
            </div>
            
            <div class="content">
                <form action="editarOk.php" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome da Categoria:</label>
                        <input type="text" name="nome" id="nome" value="<?=$retorno["nome"]?>" required/>
                        <input type="hidden" name="id" value="<?=$retorno["id"]?>"/>
                    </div>
                    <div>
                        <button type="submit" class="btn">Salvar</button>
                        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>