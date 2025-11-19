<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/categoriaDAO.class.php";

$idcategoria = $_GET["id"];
$objCategoriaDAO = new CategoriaDAO();
$retorno = $objCategoriaDAO->excluir($idcategoria);

if($retorno == true){
    header("location:listar.php?sucesso=excluir");
}
else{
    header("location:listar.php?erro=sim");
}
?>