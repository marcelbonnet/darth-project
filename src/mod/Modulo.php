<?php
namespace Darth\Core\mod;

class Modulo {
    private $nome;
    private $estado;

    public function getNome(){ return $this->nome; }
    public function setNome($val){ $this->nome=$val; }
    public function getEstado(){ return $this->estado; }
    public function setEstado($val){ $this->estado=$val; }
};
