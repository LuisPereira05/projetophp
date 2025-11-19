<?php
include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";

$objUsuario = new Usuario();
$objUsuario->setUniversal("nome", $_POST["nome"]);
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("senha", $_POST["senha"]);
$objUsuario->setUniversal("linkedin", $_POST["linkedin"]);

// Upload da imagem
$nomeImg = $_FILES["imagem"]["name"];
$TmpImg = $_FILES["imagem"]["tmp_name"];
$diretorio = "../img/".$nomeImg;

if(move_uploaded_file($TmpImg, $diretorio)){
    $objUsuario->setUniversal("imagem", $nomeImg);
}
else{
    $objUsuario->setUniversal("imagem", "");
}

$objUsuarioDAO = new UsuarioDAO();
if($objUsuarioDAO->inserir($objUsuario)){
    header("location:login.php?sucesso=cadastro");
}
else{
    header("location:cadastro.php?erro=sim");
}
?>