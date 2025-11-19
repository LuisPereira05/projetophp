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
        INSERT INTO usuario (nome, email, senha, imagem) 
        VALUES (:nome, :email, :senha, :imagem)");
        $sql->bindValue(":nome", $usuario->getUniversal("nome"));
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->bindValue(":senha", $usuario->getUniversal("senha"));
        $sql->bindValue(":imagem", $usuario->getUniversal("imagem"));
        return $sql->execute();
    }
    public function listar(){
        $sql = $this->conexao->prepare("
        SELECT * FROM usuario
        ");
        $sql->execute();
        return $sql->fetchAll();
    }
    public function buscarPorId($id){
        $sql = $this->conexao->prepare("
        SELECT * FROM usuario WHERE id=:id
        ");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch();
    }
    public function editar(usuario $usuario){
        $sql = $this->conexao->prepare("
        UPDATE usuario SET nome=:nome, email=:email,
        senha=:senha WHERE id=:id");
        $sql->bindValue(":nome", $usuario->getUniversal("nome"));
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->bindValue(":senha", $usuario->getUniversal("senha"));
        $sql->bindValue(":id", $usuario->getUniversal("id"));
        return $sql->execute();
    }
    public function excluir($id){
        $sql = $this->conexao->prepare("
        DELETE FROM usuario WHERE id=:id");
        $sql->bindValue(":id", $id);
        return $sql->execute();
    }
    public function login(usuario $usuario){
        $sql = $this->conexao->prepare("
        SELECT * FROM usuario WHERE email=:email
        ");
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->execute();
        if($sql->rowCount()>0){
            while($retorno = $sql->fetch()){
                if($retorno["senha"] == $usuario->getUniversal("senha")){
                    return $retorno;
                }
            }
            return 1;//senha errada
        }else{
            return 0;//email nao cadastrado
        }
    }


}