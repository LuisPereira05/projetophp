<?php
include_once "administrador.class.php";

class AdministradorDAO{
    private $conexao;
    
    public function __construct(){
        $this->conexao = new PDO(
            "mysql:host=localhost; dbname=bancophp",
            "root", ""
        );
    }
    
    public function login(Administrador $admin){
        $sql = $this->conexao->prepare("
            SELECT * FROM administrador WHERE email=:email
        ");
        $sql->bindValue(":email", $admin->getUniversal("email"));
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $retorno = $sql->fetch();
            if($retorno["senha"] == $admin->getUniversal("senha")){
                return $retorno;
            }
            return 1; // senha errada
        }
        return 0; // email não cadastrado
    }
}