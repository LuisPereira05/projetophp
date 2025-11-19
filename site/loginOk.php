<?php
include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";

$objUsuario = new usuario();
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("senha", $_POST["senha"]);

$objUsuarioDAO = new usuarioDAO();
$retorno = $objUsuarioDAO->login($objUsuario);
if($retorno == 0){
    header("location:login.php?erro=email");
}
elseif($retorno==1){
    header("location:login.php?erro=senha");
}else{
    session_start();
    $_SESSION["login"] = true;
    $_SESSION["id"] = $retorno["id"];
    header("location:../usuario/listar.php?sucesso=login");
}