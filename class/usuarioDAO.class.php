<?php
include_once "usuario.class.php";
class UsuarioDAO{
    private $conexao;

    public function __construct(){
        $this->conexao = new PDO(
            "mysql:host=localhost; dbname=bancophp",
            "root", ""
        );
    }

    public function inserir(usuario $usuario){
        $sql = $this->conexao->prepare("
        INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)");
        $sql->bindValue(":nome", $usuario->getUniversal("nome"));
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->bindValue(":senha", $usuario->getUniversal("senha"));
        return $sql->execute();
    }

    public function listar() {
        $sql = $this->conexao->prepare("
        SELECT * FROM usuario;");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
}
?>