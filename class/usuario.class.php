<?php

class usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function setUniversal($key, $value) {
        $this->$key = $value;
    }
    public function getUniversal($key) {
        return $this->$key;
    }
}
?>