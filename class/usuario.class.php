<?php

class usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;

    private $imagem;

    public function setUniversal($variavel, $valor){
        $this->$variavel = $valor;
    }
    public function getUniversal($variavel){
        return $this->$variavel;
    }
}