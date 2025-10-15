<?php
include_once "../class/usuarioDAO.class.php";
// echo "<pre>";
// print_r($_POST);



$objUsuario = new usuario();
$objUsuario->setUniversal("nome", $_POST["nome"]);
$objUsuario->setUniversal("email", $_POST["email"]);
$objUsuario->setUniversal("senha", $_POST["senha"]);

$dao = new UsuarioDAO();

if($dao->inserir($objUsuario)){
    //echo "inserido com sucesso";
    header("location:listar.php?sucesso=inserir");
} else {
    //echo "errado com sucesso";
    header("location:inserir.php?erro=sim");
}



?>