<?php
namespace Darth\Core\dao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @MappedSuperclass 
 */
class ProjetoBase
{
    /**
    * @Column(type="date")
    */
    protected $dataInicio;

    /**
    * @Column(type="date")
    */
    protected $dataFim;

    /** @Column(type="string", length=40) */
    protected $nome;

    /** @Column(type="text", nullable=true) */
    protected $descricao;

    /**
    * Status gerais do projeto, trocar por um Enum? 
    * 0 Não Definido, 
    * 1 Em Planejamento, 
    * 2 Proposto, 
    * 3 Em Execução, 
    * 4 Parado, 
    * 5 Concluído, 
    * 6 Arquivado, 
    * 7 Modelo
    * @Column(type="smallint")
    */
    protected $status = 0;


    public function __construct()
    {
        
    }


    public function getDataInicio()
    {
      return $this->dataInicio;
    }

    public function setDataInicio($val)
    {
      $this->dataInicio = $val;
    }

    public function getDataFim()
    {
      return $this->dataFim;
    }

    public function setDataFim($val)
    {
      $this->dataFim = $val;
    }

    public function getNome()
    {
      return $this->nome;
    }

    public function setNome($val)
    {
      $this->nome = $val;
    }

    public function getStatus()
    {
      return $this->status;
    }

    public function setStatus($val)
    {
      $this->status = $val;
    }

    /**
    * getter auto gerado
    * @return descricao 
    */
    public function getDescricao() {
        return $this->descricao;
    }
    /**
    * setter auto gerado
    * @param descricao 
    */
    public function setDescricao($descricao) {
        $this->descricao=$descricao;
    }
   
}
