<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/categoria.class.php";
include_once "../class/categoriaDAO.class.php";

$objCategoria = new Categoria();
$objCategoria->setUniversal("nome", $_POST["nome"]);

$objCategoriaDAO = new CategoriaDAO();
if($objCategoriaDAO->inserir($objCategoria)){
    header("location:listar.php?sucesso=inserir");
}
else{
    header("location:inserir.php?erro=sim");
}
?>