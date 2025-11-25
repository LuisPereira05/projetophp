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
    $objUsuario->setUniversal("senha", $_POST["senha"]);
} else {
    // Buscar senha atual do banco
    $objUsuarioDAO = new UsuarioDAO();
    $usuarioAtual = $objUsuarioDAO->buscarPorId($_POST["id"]);
    $objUsuario->setUniversal("senha", $usuarioAtual["senha"]);
}

// Upload da imagem (se houver)
if(isset($_FILES["imagem"]) && $_FILES["imagem"]["name"] != ""){
    $nomeImg = $_FILES["imagem"]["name"];
    $TmpImg = $_FILES["imagem"]["tmp_name"];
    $diretorio = "../img/".$nomeImg;
    
    // Não precisa setar a imagem no objeto, pois não atualizamos ela na query
    move_uploaded_file($TmpImg, $diretorio);
}

$objUsuarioDAO = new UsuarioDAO();
if($objUsuarioDAO->editar($objUsuario)){
    // Atualizar o nome na sessão
    $_SESSION["nome"] = $_POST["nome"];
    $_SESSION["email"] = $_POST["email"];
    header("location:perfil.php?sucesso=editar");
}
else{
    header("location:perfil.php?erro=sim");
}
?>