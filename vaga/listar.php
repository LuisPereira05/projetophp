<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/vagaDAO.class.php";
$objVagaDAO = new VagaDAO();
$retorno = $objVagaDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Vagas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gerenciar Vagas</h1>
            <p>Administrador: <?=$_SESSION["admin_nome"]?></p>
        </div>
        
        <div class="nav">
            <a href="listar.php" class="nav-btn">Vagas</a>
            <a href="../categoria/listar.php" class="nav-btn">Categorias</a>
            <a href="../admin/logout.php" class="nav-btn secondary">Sair</a>
        </div>
        
        <div class="content">
            <?php
            if(isset($_GET['sucesso'])){
                if($_GET["sucesso"] == "inserir"){
                    echo '<div class="alert alert-success">Vaga cadastrada com sucesso!</div>';
                }
                if($_GET["sucesso"] == "editar"){
                    echo '<div class="alert alert-success">Vaga editada com sucesso!</div>';
                }
                if($_GET["sucesso"] == "status"){
                    echo '<div class="alert alert-success">Status da vaga alterado com sucesso!</div>';
                }
                if($_GET["sucesso"] == "login"){
                    echo '<div class="alert alert-success">Bem-vindo de volta!</div>';
                }
            }
            ?>
            
            <a href="inserir.php" class="btn" style="margin-bottom: 20px; display: inline-block;">+ Nova Vaga</a>
            
            <table border>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Empresa</th>
                        <th>Categoria</th>
                        <th>Localização</th>
                        <th>Status</th>
                        <th colspan="3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($retorno as $linha){
                        $statusClass = $linha["ativa"] == 1 ? "badge-ativa" : "badge-inativa";
                        $statusTexto = $linha["ativa"] == 1 ? "Ativa" : "Inativa";
                        $statusAcao = $linha["ativa"] == 1 ? "Desativar" : "Ativar";
                        $statusValor = $linha["ativa"] == 1 ? 0 : 1;
                    ?>
                        <tr>
                            <td><?=$linha["id"]?></td>
                            <td><?=$linha["titulo"]?></td>
                            <td><?=$linha["empresa"]?></td>
                            <td><?=$linha["categoria_nome"]?></td>
                            <td><?=$linha["localizacao"]?></td>
                            <td><span class="vaga-badge <?=$statusClass?>"><?=$statusTexto?></span></td>
                            <td><a href="candidatos.php?id=<?=$linha["id"]?>" class="btn">Ver Candidatos</a></td>
                            <td><a href="editar.php?id=<?=$linha["id"]?>" class="btn btn-warning">Editar</a></td>
                            <td><a href="alterarStatus.php?id=<?=$linha["id"]?>&ativa=<?=$statusValor?>" class="btn btn-danger" onclick="return confirm('Deseja realmente <?=strtolower($statusAcao)?> esta vaga?')"><?=$statusAcao?></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>