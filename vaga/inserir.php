<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/categoriaDAO.class.php";
$objCategoriaDAO = new CategoriaDAO();
$categorias = $objCategoriaDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Vaga</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cadastrar Nova Vaga</h1>
        </div>
        
        <div class="content">
            <form action="inserirOk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titulo">Título da Vaga:</label>
                    <input type="text" name="titulo" id="titulo" required placeholder="Ex: Desenvolvedor Full Stack"/>
                </div>
                
                <div class="form-group">
                    <label for="empresa">Empresa:</label>
                    <input type="text" name="empresa" id="empresa" required placeholder="Nome da empresa"/>
                </div>
                
                <div class="form-group">
                    <label for="categoria_id">Categoria:</label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="">Selecione uma categoria</option>
                        <?php
                        foreach($categorias as $categoria){
                            echo '<option value="'.$categoria["id"].'">'.$categoria["nome"].'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" required placeholder="Descreva a vaga..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="requisitos">Requisitos:</label>
                    <textarea name="requisitos" id="requisitos" required placeholder="Liste os requisitos necessários..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="salario">Salário:</label>
                    <input type="text" name="salario" id="salario" placeholder="Ex: R$ 5.000 - R$ 8.000"/>
                </div>
                
                <div class="form-group">
                    <label for="localizacao">Localização:</label>
                    <input type="text" name="localizacao" id="localizacao" required placeholder="Ex: São Paulo - SP"/>
                </div>
                
                <div class="form-group">
                    <label for="tipo_contrato">Tipo de Contrato:</label>
                    <select name="tipo_contrato" id="tipo_contrato" required>
                        <option value="">Selecione</option>
                        <option value="CLT">CLT</option>
                        <option value="PJ">PJ</option>
                        <option value="Estágio">Estágio</option>
                        <option value="Temporário">Temporário</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="contato_email">E-mail para Contato:</label>
                    <input type="email" name="contato_email" id="contato_email" required placeholder="contato@empresa.com"/>
                </div>
                
                <div class="form-group">
                    <label for="contato_telefone">Telefone para Contato:</label>
                    <input type="tel" name="contato_telefone" id="contato_telefone" placeholder="(11) 98765-4321"/>
                </div>
                
                <div class="form-group">
                    <label for="imagem">Imagem da Vaga:</label>
                    <input type="file" name="imagem" id="imagem" accept="image/*"/>
                </div>
                
                <div>
                    <button type="submit" class="btn">Cadastrar Vaga</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>