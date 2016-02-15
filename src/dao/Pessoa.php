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
 * @Entity 
 * @Table(name="core__pessoas")
 */
class Pessoa extends PessoaBase
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

    /**
    * @ManyToOne(targetEntity="Atividade", inversedBy="pessoas")
    */
    protected $atividade = null;

    public function __construct()
    {
        
    }

    public function getId()
    {
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function getAtividade()
    {
      return $this->atividade;
    }

    public function setAtividade($val)
    {
      $this->atividade = $val;
    }


   public function __toString()
   {
      return strval("[Class=Pessoa" 
     .", id=".$this->getId()
     .", Nome=".$this->getNome()
     .", Matrícula=".$this->getMatricula()
     ."]");
   }
}
