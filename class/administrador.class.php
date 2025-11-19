<?php

class Administrador{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function setUniversal($variavel, $valor){
        $this->$variavel = $valor;
    }
    
    public function getUniversal($variavel){
        return $this->$variavel;
    }
}