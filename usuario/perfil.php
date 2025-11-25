<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
    exit;
}

include_once "../class/usuarioDAO.class.php";

$idusuario = $_SESSION["id"];
$objUsuarioDAO = new UsuarioDAO();
$usuario = $objUsuarioDAO->buscarPorId($idusuario);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Meu Perfil</h1>
            <p>Gerencie suas informações pessoais</p>
        </div>
        
        <div class="nav">
            <a href="../site/index.php" class="nav-btn">Vagas Disponíveis</a>
            <a href="minhasCandidaturas.php" class="nav-btn">Minhas Candidaturas</a>
            <a href="perfil.php" class="nav-btn">Meu Perfil</a>
            <a href="../site/logout.php" class="nav-btn secondary">Sair</a>
        </div>
        
        <div class="content">
            <?php
            if(isset($_GET['sucesso'])){
                if($_GET["sucesso"] == "editar"){
                    echo '<div class="alert alert-success">Perfil atualizado com sucesso!</div>';
                }
            }
            if(isset($_GET['erro'])){
                echo '<div class="alert alert-error">Erro ao atualizar perfil. Tente novamente.</div>';
            }
            ?>
            
            <div style="display: flex; align-items: center; gap: 30px; margin-bottom: 30px; flex-wrap: wrap;">
                <?php if($usuario["imagem"]): ?>
                    <img src="../img/<?=$usuario["imagem"]?>" alt="Foto de Perfil" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #667eea;">
                <?php else: ?>
                    <img src="https://via.placeholder.com/150" alt="Foto de Perfil" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #667eea;">
                <?php endif; ?>
                
                <div>
                    <h2 style="margin-bottom: 10px;"><?=$usuario["nome"]?></h2>
                    <p style="color: #666; margin-bottom: 5px;"><strong>E-mail:</strong> <?=$usuario["email"]?></p>
                    <?php if($usuario["linkedin"]): ?>
                        <p style="margin-top: 10px;">
                            <a href="<?=$usuario["linkedin"]?>" target="_blank" class="linkedin-link">
                                🔗 Ver perfil no LinkedIn
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <h3 style="margin-top: 40px; margin-bottom: 20px;">Editar Informações</h3>
            
            <form action="perfilOk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$usuario["id"]?>"/>
                
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" name="nome" id="nome" value="<?=$usuario["nome"]?>" required/>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" value="<?=$usuario["email"]?>" required/>
                </div>
                
                <div class="form-group">
                    <label for="senha">Nova Senha (deixe em branco para manter a atual):</label>
                    <input type="password" name="senha" id="senha" placeholder="Digite uma nova senha ou deixe em branco"/>
                </div>
                
                <div class="form-group">
                    <label for="linkedin">LinkedIn (URL):</label>
                    <input type="url" name="linkedin" id="linkedin" value="<?=$usuario["linkedin"]?>" placeholder="https://linkedin.com/in/seu-perfil"/>
                </div>
                
                <div class="form-group">
                    <label for="imagem">Atualizar Foto de Perfil:</label>
                    <input type="file" name="imagem" id="imagem" accept="image/*"/>
                    <small style="color: #666; display: block; margin-top: 5px;">Deixe em branco para manter a foto atual</small>
                </div>
                
                <div>
                    <button type="submit" class="btn">Salvar Alterações</button>
                    <a href="../site/index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>