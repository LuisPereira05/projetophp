<?php
include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";
//echo "<pre>";
//print_r($_POST);
$objUsuario = new usuario();
$objUsuario->setUniversal("nome", $_POST["nome"]);
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("senha", $_POST["senha"]);

$nomeImg = $_FILES["imagem"]["name"];
$TmpImg = $_FILES["imagem"]["tmp_name"];
$diretorio = "../img/".$nomeImg;
if(move_uploaded_file($TmpImg, $diretorio)){
    $objUsuario->setUniversal("imagem", $nomeImg);
}
else{
    $objUsuario->setUniversal("imagem", "");
}

$objUsuarioDAO = new usuarioDAO();
if($objUsuarioDAO->inserir($objUsuario)){
    //echo "inserido com sucesso";
    header("location:listar.php?sucesso=inserir");
}
else{
    //echo "errado com sucesso";
    header("location:inserir.php?erro=sim");
}

?>