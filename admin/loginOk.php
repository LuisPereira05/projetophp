<?php
include_once "../class/administrador.class.php";
include_once "../class/administradorDAO.class.php";

$objAdmin = new Administrador();
$objAdmin->setUniversal("email", $_POST["email"]);
$objAdmin->setUniversal("senha", $_POST["senha"]);

$objAdminDAO = new AdministradorDAO();
$retorno = $objAdminDAO->login($objAdmin);

if($retorno == 0){
    header("location:login.php?erro=email");
}
elseif($retorno == 1){
    header("location:login.php?erro=senha");
}
else{
    session_start();
    $_SESSION["admin"] = true;
    $_SESSION["admin_id"] = $retorno["id"];
    $_SESSION["admin_nome"] = $retorno["nome"];
    header("location:../vaga/listar.php?sucesso=login");
}
?>