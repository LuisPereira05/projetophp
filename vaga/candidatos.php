<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/vagaDAO.class.php";

$idvaga = $_GET["id"];
$objVagaDAO = new VagaDAO();
$vaga = $objVagaDAO->buscarPorId($idvaga);
$candidatos = $objVagaDAO->listarCandidatos($idvaga);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos da Vaga</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../includes/sidebar.php"; ?>
    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1>Candidatos da Vaga</h1>
            </div>
            
            <div class="content">
                <a href="listar.php" class="btn btn-secondary" style="margin-bottom: 20px; display: inline-block;">← Voltar</a>
                
                <div class="vaga-card">
                    <h3><?=$vaga["titulo"]?></h3>
                    <p><strong>Empresa:</strong> <?=$vaga["empresa"]?></p>
                    <p><strong>Categoria:</strong> <?=$vaga["categoria_nome"]?></p>
                </div>
                
                <h2 style="margin: 30px 0 20px 0;">Candidatos Inscritos (<?=count($candidatos)?>)</h2>
                
                <?php if(count($candidatos) == 0): ?>
                    <div class="empty-state">
                        <h3>Nenhum candidato inscrito ainda</h3>
                        <p>Quando usuários se candidatarem a esta vaga, eles aparecerão aqui.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($candidatos as $candidato): ?>
                        <div class="candidato-card">
                            <?php if($candidato["imagem"]): ?>
                                <img src="../img/<?=$candidato["imagem"]?>" alt="Foto" class="candidato-foto">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/80" alt="Foto" class="candidato-foto">
                            <?php endif; ?>
                            
                            <div class="candidato-info">
                                <div class="candidato-nome"><?=$candidato["nome"]?></div>
                                <div class="candidato-email"><?=$candidato["email"]?></div>
                                <?php if($candidato["linkedin"]): ?>
                                    <a href="<?=$candidato["linkedin"]?>" target="_blank" class="linkedin-link">
                                        Ver perfil no LinkedIn →
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>