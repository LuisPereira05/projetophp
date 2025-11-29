<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/vagaDAO.class.php";
include_once "../class/categoriaDAO.class.php";

$idvaga = $_GET["id"];
$objVagaDAO = new VagaDAO();
$vaga = $objVagaDAO->buscarPorId($idvaga);

$objCategoriaDAO = new CategoriaDAO();
$categorias = $objCategoriaDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "../includes/sidebar.php"; ?>

    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1>Editar Vaga</h1>
            </div>
            
            <div class="content">
                <form action="editarOk.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$vaga["id"]?>"/>
                    
                    <div class="form-group">
                        <label for="titulo">Título da Vaga:</label>
                        <input type="text" name="titulo" id="titulo" value="<?=$vaga["titulo"]?>" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="empresa">Empresa:</label>
                        <input type="text" name="empresa" id="empresa" value="<?=$vaga["empresa"]?>" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoria_id">Categoria:</label>
                        <select name="categoria_id" id="categoria_id" required>
                            <?php
                            foreach($categorias as $categoria){
                                $selected = $categoria["id"] == $vaga["categoria_id"] ? "selected" : "";
                                echo '<option value="'.$categoria["id"].'" '.$selected.'>'.$categoria["nome"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea name="descricao" id="descricao" required><?=$vaga["descricao"]?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="requisitos">Requisitos:</label>
                        <textarea name="requisitos" id="requisitos" required><?=$vaga["requisitos"]?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="salario">Salário:</label>
                        <input type="text" name="salario" id="salario" value="<?=$vaga["salario"]?>"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="localizacao">Localização:</label>
                        <input type="text" name="localizacao" id="localizacao" value="<?=$vaga["localizacao"]?>" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo_contrato">Tipo de Contrato:</label>
                        <select name="tipo_contrato" id="tipo_contrato" required>
                            <option value="CLT" <?=$vaga["tipo_contrato"]=="CLT"?"selected":""?>>CLT</option>
                            <option value="PJ" <?=$vaga["tipo_contrato"]=="PJ"?"selected":""?>>PJ</option>
                            <option value="Estágio" <?=$vaga["tipo_contrato"]=="Estágio"?"selected":""?>>Estágio</option>
                            <option value="Temporário" <?=$vaga["tipo_contrato"]=="Temporário"?"selected":""?>>Temporário</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="contato_email">E-mail para Contato:</label>
                        <input type="email" name="contato_email" id="contato_email" value="<?=$vaga["contato_email"]?>" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="contato_telefone">Telefone para Contato:</label>
                        <input type="tel" name="contato_telefone" id="contato_telefone" value="<?=$vaga["contato_telefone"]?>"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="ativa">Status:</label>
                        <select name="ativa" id="ativa" required>
                            <option value="1" <?=$vaga["ativa"]==1?"selected":""?>>Ativa</option>
                            <option value="0" <?=$vaga["ativa"]==0?"selected":""?>>Inativa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="imagem">Imagem da Vaga:</label>
                        <?php if(!empty($vaga["imagem"])): ?>
                            <div style="margin-bottom: 10px;">
                                <img src="../img/<?=$vaga["imagem"]?>" alt="Imagem atual" style="max-width: 200px; height: auto;">
                                <p>Imagem atual</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="imagem" id="imagem" accept="image/*"/>
                        <small>Deixe em branco para manter a imagem atual</small>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn">Salvar Alterações</button>
                        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>