<?php
include_once "categoria.class.php";

class CategoriaDAO{
    private $conexao;
    
    public function __construct(){
        $this->conexao = new PDO(
            "mysql:host=localhost; dbname=bancophp",
            "root", ""
        );
    }
    
    public function inserir(Categoria $categoria){
        $sql = $this->conexao->prepare("
            INSERT INTO categoria (nome) VALUES (:nome)
        ");
        $sql->bindValue(":nome", $categoria->getUniversal("nome"));
        return $sql->execute();
    }
    
    public function listar(){
        $sql = $this->conexao->prepare("SELECT * FROM categoria ORDER BY nome");
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function buscarPorId($id){
        $sql = $this->conexao->prepare("SELECT * FROM categoria WHERE id=:id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function editar(Categoria $categoria){
        $sql = $this->conexao->prepare("
            UPDATE categoria SET nome=:nome WHERE id=:id
        ");
        $sql->bindValue(":nome", $categoria->getUniversal("nome"));
        $sql->bindValue(":id", $categoria->getUniversal("id"));
        return $sql->execute();
    }
    
    public function excluir($id){
        $sql = $this->conexao->prepare("DELETE FROM categoria WHERE id=:id");
        $sql->bindValue(":id", $id);
        return $sql->execute();
    }
}