<?php
include_once "../class/usuario.class.php";
include_once "../class/usuarioDAO.class.php";

$objUsuario = new Usuario();
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("senha", $_POST["senha"]);

$objUsuarioDAO = new UsuarioDAO();
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
    $_SESSION["nome"] = $retorno["nome"];
    $_SESSION["email"] = $retorno["email"];
    header("location:index.php?sucesso=login");
}
?>