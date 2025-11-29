<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/categoriaDAO.class.php";
$objCategoriaDAO = new CategoriaDAO();
$retorno = $objCategoriaDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../includes/sidebar.php"; ?>

    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1>Gerenciar Categorias</h1>
                <p>Administrador: <?=$_SESSION["admin_nome"]?></p>
            </div>
            
            <div class="content">
                <?php
                if(isset($_GET['sucesso'])){
                    if($_GET["sucesso"] == "inserir"){
                        echo '<div class="alert alert-success">Categoria cadastrada com sucesso!</div>';
                    }
                    if($_GET["sucesso"] == "editar"){
                        echo '<div class="alert alert-success">Categoria editada com sucesso!</div>';
                    }
                    if($_GET["sucesso"] == "excluir"){
                        echo '<div class="alert alert-success">Categoria excluída com sucesso!</div>';
                    }
                }
                ?>
                
                <a href="inserir.php" class="btn" style="margin-bottom: 20px; display: inline-block;">+ Nova Categoria</a>
                
                <table border>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($retorno as $linha){
                        ?>
                            <tr>
                                <td><?=$linha["id"]?></td>
                                <td><?=$linha["nome"]?></td>
                                <td><a href="editar.php?id=<?=$linha["id"]?>" class="btn btn-warning">Editar</a></td>
                                <td><a href="excluir.php?id=<?=$linha["id"]?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir esta categoria?')">Excluir</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>