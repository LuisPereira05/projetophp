<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/vagaDAO.class.php";

$idvaga = $_GET["id"];
$ativa = $_GET["ativa"];

$objVagaDAO = new VagaDAO();
$retorno = $objVagaDAO->alterarStatus($idvaga, $ativa);

if($retorno == true){
    header("location:listar.php?sucesso=status");
}
else{
    header("location:listar.php?erro=sim");
}
?>