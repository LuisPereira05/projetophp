<?php
session_start();
include_once "../class/vagaDAO.class.php";
include_once "../class/categoriaDAO.class.php";

$objVagaDAO = new VagaDAO();
$objCategoriaDAO = new CategoriaDAO();

// Configuração de paginação
$vagasPorPagina = 10;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $vagasPorPagina;

// Verificar se há filtro por categoria
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : null;

// Buscar vagas e total
if($categoria_filtro){
    $vagas = $objVagaDAO->listarPorCategoriaComPaginacao($categoria_filtro, $vagasPorPagina, $offset);
    $totalVagas = $objVagaDAO->contarPorCategoria($categoria_filtro);
} else {
    $vagas = $objVagaDAO->listarAtivasComPaginacao($vagasPorPagina, $offset);
    $totalVagas = $objVagaDAO->contarAtivas();
}

$totalPaginas = ceil($totalVagas / $vagasPorPagina);
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
    <?php include_once "../includes/sidebar.php"; ?>

    <div class="main-content">

        <div class="container">
            <div class="header">
                <h1>Portal de Vagas</h1>
                <p>Conectando talentos às melhores oportunidades</p>
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
                
                <h2 style="margin-bottom: 30px; color: #cacaca;">Vagas Disponíveis (<?=$totalVagas?> vagas)</h2>
                
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
                    
                    <!-- Paginação -->
                    <?php if($totalPaginas > 1): ?>
                        <div class="pagination">
                            <?php
                            // Construir URL base mantendo o filtro de categoria
                            $url_base = "index.php?";
                            if($categoria_filtro){
                                $url_base .= "categoria=".$categoria_filtro."&";
                            }
                            ?>
                            
                            <!-- Botão Anterior -->
                            <?php if($paginaAtual > 1): ?>
                                <a href="<?=$url_base?>pagina=<?=($paginaAtual-1)?>" class="pagination-btn">« Anterior</a>
                            <?php endif; ?>
                            
                            <!-- Números das páginas -->
                            <?php
                            $inicio = max(1, $paginaAtual - 2);
                            $fim = min($totalPaginas, $paginaAtual + 2);
                            
                            if($inicio > 1){
                                echo '<a href="'.$url_base.'pagina=1" class="pagination-btn">1</a>';
                                if($inicio > 2){
                                    echo '<span class="pagination-dots">...</span>';
                                }
                            }
                            
                            for($i = $inicio; $i <= $fim; $i++){
                                $active = $i == $paginaAtual ? 'active' : '';
                                echo '<a href="'.$url_base.'pagina='.$i.'" class="pagination-btn '.$active.'">'.$i.'</a>';
                            }
                            
                            if($fim < $totalPaginas){
                                if($fim < $totalPaginas - 1){
                                    echo '<span class="pagination-dots">...</span>';
                                }
                                echo '<a href="'.$url_base.'pagina='.$totalPaginas.'" class="pagination-btn">'.$totalPaginas.'</a>';
                            }
                            ?>
                            
                            <!-- Botão Próximo -->
                            <?php if($paginaAtual < $totalPaginas): ?>
                                <a href="<?=$url_base?>pagina=<?=($paginaAtual+1)?>" class="pagination-btn">Próximo »</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>