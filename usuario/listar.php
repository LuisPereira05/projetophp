<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../site/login.php");
}
include_once "../class/usuarioDAO.class.php";
$objUsuarioDAO = new usuarioDAO();
$retorno = $objUsuarioDAO->listar();
if(isset($_GET['sucesso'])){
    if($_GET["sucesso"] == "inserir"){
        echo "<h2>Inserido com sucesso!</h2>";
    }
    if($_GET["sucesso"] == "login"){
        echo "<h2>Bem vindo de volta</h2>";
    }
}
?>
<table border>
    <thead>
        <th>Id</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Senha</th>
        <th colspan="2">Ações</th>
    </thead>
    <tbody>
        <?php
        foreach($retorno as $linha){
          ?>
            <tr>
                <td><?=$linha["id"]?></td>
                <td><?=$linha["nome"]?></td>
                <td><?=$linha["email"]?></td>
                <td><?=$linha["senha"]?></td>
                <td><a href="editar.php?id=<?=$linha["id"]?>">Editar</a></td>
                <td><a href="excluir.php?id=<?=$linha["id"]?>">Excluir</a></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>