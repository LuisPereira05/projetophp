<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
}
include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";
$idusuario = $_GET["id"];
$objUsuarioDAO = new usuarioDAO();
$retorno = $objUsuario->excluir($idusuario);
if($retorno == true){
    header("location:listar.php?sucesso=excluir");
}
else{
    header("location:listar.php?erro=sim");
}
?>