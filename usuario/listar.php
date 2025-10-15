<?php
include_once "../class/usuarioDAO.class.php";
$dao = new UsuarioDAO();
$retorno = $dao->listar();


?>
<table border>
    <thead>
        <th>Id</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Senha</th>
    </thead>
    <tbody>
        <?php
        foreach ($retorno as $linha) {
            ?>
            <tr>
                <td><?=$linha['id']?></td>
                <td><?=$linha['nome']?></td>
                <td><?=$linha['email']?></td>
                <td><?=$linha['senha']?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>