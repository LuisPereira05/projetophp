<?php
session_start();
include_once "../class/vagaDAO.class.php";
include_once "../class/categoriaDAO.class.php";

$objVagaDAO = new VagaDAO();
$objCategoriaDAO = new CategoriaDAO();

// Verificar se há filtro por categoria
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : null;

if($categoria_filtro){
    $vagas = $objVagaDAO->listarPorCategoria($categoria_filtro);
} else {
    $vagas = $objVagaDAO->listarAtivas();
}

$categorias = $objCategoriaDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Vagas de Emprego</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Portal de Vagas</h1>
            <p>Conectando talentos às melhores oportunidades</p>
        </div>
        
        <div class="nav">
            <div class="nav-links">
                <a href="index.php" class="nav-btn">Início</a>
                <?php if(isset($_SESSION["login"])): ?>
                    <a href="../usuario/minhasCandidaturas.php" class="nav-btn">Minhas Candidaturas</a>
                    <a href="../usuario/perfil.php" class="nav-btn">Meu Perfil</a>
                <?php else: ?>
                    <a href="cadastro.php" class="nav-btn">Cadastre-se</a>
                    <a href="login.php" class="nav-btn">Login</a>
                <?php endif; ?>
                <a href="../admin/login.php" class="nav-btn secondary">Área Admin</a>
            </div>
            <?php if(isset($_SESSION["login"])): ?>
                <div>
                    <span style="margin-right: 15px; font-weight: 600; color: #cacaca;">Olá, <?=$_SESSION["nome"]?>!</span>
                    <a href="logout.php" class="nav-btn secondary">Sair</a>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="content">
            <?php
            if(isset($_GET['sucesso'])){
                if($_GET["sucesso"] == "candidatura"){
                    echo '<div class="alert alert-success">Candidatura realizada com sucesso! Boa sorte!</div>';
                }
                if($_GET["sucesso"] == "login"){
                    echo '<div class="alert alert-success">Bem-vindo de volta!</div>';
                }
            }
            if(isset($_GET['erro'])){
                if($_GET["erro"] == "ja_candidatado"){
                    echo '<div class="alert alert-error">Você já se candidatou a esta vaga!</div>';
                }
            }
            ?>
            
            <h2 style="margin-bottom: 30px; color: #cacaca;">Vagas Disponíveis</h2>
            
            <!-- Filtro por Categoria -->
            <div class="filter-section">
                <h3>Filtrar por Categoria</h3>
                <div class="categoria-filter">
                    <a href="index.php" class="categoria-btn <?=!$categoria_filtro ? 'active' : ''?>">Todas</a>
                    <?php foreach($categorias as $cat): ?>
                        <a href="index.php?categoria=<?=$cat['id']?>" class="categoria-btn <?=$categoria_filtro == $cat['id'] ? 'active' : ''?>">
                            <?=$cat['nome']?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Lista de Vagas -->
            <?php if(count($vagas) == 0): ?>
                <div class="empty-state">
                    <h3>Nenhuma vaga encontrada</h3>
                    <p>Não há vagas disponíveis nesta categoria no momento.</p>
                </div>
            <?php else: ?>
                <?php foreach($vagas as $vaga): ?>
                    <div class="vaga-card">
                        <div class="vaga-header">
                            <div>
                                <h3 class="vaga-titulo"><?=$vaga["titulo"]?></h3>
                                <p class="vaga-empresa"><?=$vaga["empresa"]?></p>
                            </div>
                            <span class="vaga-badge badge-ativa">Ativa</span>
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
                        
                        <p class="vaga-descricao"><?=$vaga["descricao"]?></p>
                        
                        <p style="color: #cacaca; margin: 10px 0;">
                            <strong>Requisitos:</strong> <?=$vaga["requisitos"]?>
                        </p>
                        
                        <p style="color: #cacaca; margin: 10px 0;">
                            <strong>Contato:</strong> <?=$vaga["contato_email"]?>
                            <?php if($vaga["contato_telefone"]): ?>
                                | <?=$vaga["contato_telefone"]?>
                            <?php endif; ?>
                        </p>
                        
                        <div class="vaga-actions">
                            <?php if(isset($_SESSION["login"])): ?>
                                <a href="../usuario/candidatar.php?id=<?=$vaga["id"]?>" class="btn btn-success">Candidatar-se</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-success">Faça login para se candidatar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>