<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
    exit;
}

include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";

$objUsuario = new Usuario();
$objUsuario->setUniversal("id", $_POST["id"]);
$objUsuario->setUniversal("nome", $_POST["nome"]);
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("linkedin", $_POST["linkedin"]);

// Se a senha foi preenchida, atualiza. Caso contrário, mantém a antiga
if(!empty($_POST["senha"])){
    $objUsuario->setUniversal("senha", md5($_POST["senha"]));
} else {
    // Buscar senha atual do banco
    $objUsuarioDAO = new UsuarioDAO();
    $usuarioAtual = $objUsuarioDAO->buscarPorId($_POST["id"]);
    $objUsuario->setUniversal("senha", $usuarioAtual["senha"]);
}

// Handle image upload
$imagemNome = null;

if(isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0){
    // Get file info
    $arquivo = $_FILES["imagem"];
    $nomeArquivo = $arquivo["name"];
    $tamanhoArquivo = $arquivo["size"];
    $tmpArquivo = $arquivo["tmp_name"];
    
    // Check if it's a valid image
    $extensoesPermitidas = array("jpg", "jpeg", "png", "gif", "webp");
    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
    
    if(in_array($extensao, $extensoesPermitidas)){
        // Check file size (max 5MB)
        if($tamanhoArquivo <= 5000000){
            // Generate unique filename
            $novoNome = uniqid() . "." . $extensao;
            $destino = "../img/" . $novoNome;
            
            // Move uploaded file
            if(move_uploaded_file($tmpArquivo, $destino)){
                $imagemNome = $novoNome;
                
                // Delete old image if exists
                $objUsuarioDAO = new UsuarioDAO();
                $usuarioAtual = $objUsuarioDAO->buscarPorId($_POST["id"]);
                if(!empty($usuarioAtual["imagem"]) && file_exists("../img/" . $usuarioAtual["imagem"])){
                    unlink("../img/" . $usuarioAtual["imagem"]);
                }
            }
        }
    }
}

// Set image if uploaded, otherwise keep the old one
if($imagemNome !== null){
    $objUsuario->setUniversal("imagem", $imagemNome);
} else {
    // Keep the existing image
    $objUsuarioDAO = new UsuarioDAO();
    $usuarioAtual = $objUsuarioDAO->buscarPorId($_POST["id"]);
    $objUsuario->setUniversal("imagem", $usuarioAtual["imagem"]);
}

$objUsuarioDAO = new UsuarioDAO();
if($objUsuarioDAO->editar($objUsuario)){
    // Atualizar o nome e email na sessão
    $_SESSION["nome"] = $_POST["nome"];
    $_SESSION["email"] = $_POST["email"];
    header("location:perfil.php?sucesso=editar");
}
else{
    header("location:perfil.php?erro=sim");
}
?>