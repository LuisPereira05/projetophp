<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
    exit;
}

include_once "../class/vagaDAO.class.php";

$idvaga = $_GET["id"];
$idusuario = $_SESSION["id"];

$objVagaDAO = new VagaDAO();

// Verificar se já se candidatou
if($objVagaDAO->verificarCandidatura($idusuario, $idvaga)){
    header("location:../site/index.php?erro=ja_candidatado");
    exit;
}

// Realizar candidatura
if($objVagaDAO->candidatar($idusuario, $idvaga)){
    header("location:../site/index.php?sucesso=candidatura");
}
else{
    header("location:../site/index.php?erro=candidatura");
}
?>