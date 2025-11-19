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
$objCategoria->setUniversal("id", $_POST["id"]);

$objCategoriaDAO = new CategoriaDAO();
if($objCategoriaDAO->editar($objCategoria)){
    header("location:listar.php?sucesso=editar");
}
else{
    header("location:editar.php?id=".$_POST["id"]."&erro=sim");
}
?>