<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/vaga.class.php";
include_once "../class/vagaDAO.class.php";

$objVaga = new Vaga();
$objVaga->setUniversal("titulo", $_POST["titulo"]);
$objVaga->setUniversal("empresa", $_POST["empresa"]);
$objVaga->setUniversal("categoria_id", $_POST["categoria_id"]);
$objVaga->setUniversal("descricao", $_POST["descricao"]);
$objVaga->setUniversal("requisitos", $_POST["requisitos"]);
$objVaga->setUniversal("salario", $_POST["salario"]);
$objVaga->setUniversal("localizacao", $_POST["localizacao"]);
$objVaga->setUniversal("tipo_contrato", $_POST["tipo_contrato"]);
$objVaga->setUniversal("contato_email", $_POST["contato_email"]);
$objVaga->setUniversal("contato_telefone", $_POST["contato_telefone"]);
$objVaga->setUniversal("ativa", 1);

// Upload da imagem
$nomeImg = $_FILES["imagem"]["name"];
$TmpImg = $_FILES["imagem"]["tmp_name"];
$diretorio = "../img/".$nomeImg;

if(move_uploaded_file($TmpImg, $diretorio)){
    $objVaga->setUniversal("imagem", $nomeImg);
}
else{
    $objVaga->setUniversal("imagem", "");
}

$objVagaDAO = new VagaDAO();
if($objVagaDAO->inserir($objVaga)){
    header("location:listar.php?sucesso=inserir");
}
else{
    header("location:inserir.php?erro=sim");
}
?>