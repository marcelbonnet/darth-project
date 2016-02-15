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

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->atividades = new ArrayCollection();
    }

    public function getId()
    {
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
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
