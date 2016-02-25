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
class PessoaBase
{
    /**
    * @Column(type="integer")
    */
    protected $matricula;

    /** @Column(type="string", length=255) */
    protected $nome;


    public function __construct()
    {
        
    }

    public function getMatricula()
    {
      return $this->matricula;
    }

    public function setMatricula($val)
    {
      $this->matricula = $val;
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
