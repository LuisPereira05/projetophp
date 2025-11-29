<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
    exit;
}

include_once "../class/vagaDAO.class.php";

$idusuario = $_SESSION["id"];
$objVagaDAO = new VagaDAO();

// Buscar vagas que o usuário se candidatou
$conn = new PDO("mysql:host=localhost; dbname=bancophp", "root", "");
$sql = $conn->prepare("
    SELECT v.*, c.nome as categoria_nome, cand.data_candidatura 
    FROM vaga v 
    INNER JOIN categoria c ON v.categoria_id = c.id
    INNER JOIN candidatura cand ON v.id = cand.vaga_id
    WHERE cand.usuario_id = :usuario_id
    ORDER BY cand.data_candidatura DESC
");
$sql->bindValue(":usuario_id", $idusuario);
$sql->execute();
$minhasCandidaturas = $sql->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../includes/sidebar.php"; ?>
    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1>Minhas Candidaturas</h1>
                <p>Olá, <?=$_SESSION["nome"]?>!</p>
            </div>
            
            <div class="content">
                <h2 style="margin-bottom: 20px;">Você se candidatou a <?=count($minhasCandidaturas)?> vaga(s)</h2>
                
                <?php if(count($minhasCandidaturas) == 0): ?>
                    <div class="empty-state">
                        <h3>Você ainda não se candidatou a nenhuma vaga</h3>
                        <p>Explore as vagas disponíveis e candidate-se!</p>
                        <a href="../site/index.php" class="btn" style="margin-top: 20px; display: inline-block;">Ver Vagas</a>
                    </div>
                <?php else: ?>
                    <?php foreach($minhasCandidaturas as $vaga): ?>
                        <div class="vaga-card">
                            <?php if(!empty($vaga["imagem"])): ?>
                                <div class="vaga-imagem">
                                    <img src="../img/<?=$vaga["imagem"]?>" alt="<?=htmlspecialchars($vaga["titulo"])?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="vaga-header">
                                <div>
                                    <h3 class="vaga-titulo"><?=$vaga["titulo"]?></h3>
                                    <p class="vaga-empresa"><?=$vaga["empresa"]?></p>
                                </div>
                                <span class="vaga-badge <?=$vaga['ativa'] ? 'badge-ativa' : 'badge-inativa'?>">
                                    <?=$vaga['ativa'] ? 'Ativa' : 'Inativa'?>
                                </span>
                            </div>
                            
                            <div class="vaga-info">
                                <div class="info-item">
                                    <strong>📍</strong> <?=$vaga["localizacao"]?>
                                </div>
                                <?php if($vaga["salario"]): ?>
                                    <div class="info-item">
                                        <strong>💰</strong> <?=$vaga["salario"]?>
                                    </div>
                                <?php endif; ?>
                                <div class="info-item">
                                    <strong>📋</strong> <?=$vaga["tipo_contrato"]?>
                                </div>
                                <div class="info-item">
                                    <strong>🏷️</strong> <?=$vaga["categoria_nome"]?>
                                </div>
                            </div>
                            
                            <p style="color: #cacaca; margin-top: 15px;">
                                <strong>Candidatura enviada em:</strong> <?=date('d/m/Y H:i', strtotime($vaga["data_candidatura"]))?>
                            </p>
                            
                            <p style="color: #cacaca; margin-top: 10px;">
                                <strong>Contato:</strong> <?=$vaga["contato_email"]?>
                                <?php if($vaga["contato_telefone"]): ?>
                                    | <?=$vaga["contato_telefone"]?>
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>