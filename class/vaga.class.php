<?php

class Vaga{
    private $id;
    private $titulo;
    private $descricao;
    private $requisitos;
    private $salario;
    private $localizacao;
    private $tipo_contrato;
    private $empresa;
    private $contato_email;
    private $contato_telefone;
    private $imagem;
    private $categoria_id;
    private $ativa;

    public function setUniversal($variavel, $valor){
        $this->$variavel = $valor;
    }
    
    public function getUniversal($variavel){
        return $this->$variavel;
    }
}