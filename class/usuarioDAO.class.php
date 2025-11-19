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
    
    public function inserir(Usuario $usuario){
        $sql = $this->conexao->prepare("
            INSERT INTO usuario (nome, email, senha, imagem, linkedin) 
            VALUES (:nome, :email, :senha, :imagem, :linkedin)
        ");
        $sql->bindValue(":nome", $usuario->getUniversal("nome"));
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->bindValue(":senha", $usuario->getUniversal("senha"));
        $sql->bindValue(":imagem", $usuario->getUniversal("imagem"));
        $sql->bindValue(":linkedin", $usuario->getUniversal("linkedin"));
        return $sql->execute();
    }
    
    public function listar(){
        $sql = $this->conexao->prepare("SELECT * FROM usuario");
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function buscarPorId($id){
        $sql = $this->conexao->prepare("SELECT * FROM usuario WHERE id=:id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function editar(Usuario $usuario){
        $sql = $this->conexao->prepare("
            UPDATE usuario SET nome=:nome, email=:email, 
            senha=:senha, linkedin=:linkedin WHERE id=:id
        ");
        $sql->bindValue(":nome", $usuario->getUniversal("nome"));
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->bindValue(":senha", $usuario->getUniversal("senha"));
        $sql->bindValue(":linkedin", $usuario->getUniversal("linkedin"));
        $sql->bindValue(":id", $usuario->getUniversal("id"));
        return $sql->execute();
    }
    
    public function excluir($id){
        $sql = $this->conexao->prepare("DELETE FROM usuario WHERE id=:id");
        $sql->bindValue(":id", $id);
        return $sql->execute();
    }
    
    public function login(Usuario $usuario){
        $sql = $this->conexao->prepare("SELECT * FROM usuario WHERE email=:email");
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $retorno = $sql->fetch();
            if($retorno["senha"] == $usuario->getUniversal("senha")){
                return $retorno;
            }
            return 1; // senha errada
        }
        return 0; // email não cadastrado
    }
}