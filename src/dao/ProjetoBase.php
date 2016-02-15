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

   
}
