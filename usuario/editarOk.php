<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
}
include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";
//echo "<pre>";
//print_r($_POST);
$objUsuario = new usuario();
$objUsuario->setUniversal("nome", $_POST["nome"]);
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("senha", $_POST["senha"]);
$objUsuario->setUniversal("id", $_POST["id"]);

$objUsuarioDAO = new usuarioDAO();
if($objUsuarioDAO->editar($objUsuario)){
    //echo "inserido com sucesso";
    header("location:listar.php?sucesso=editar");
}
else{
    //echo "errado com sucesso";
    header("location:editar.php?erro=sim");
}

?>