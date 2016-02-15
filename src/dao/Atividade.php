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
 * @Table(name="core__atividades")
 */
class Atividade extends AtividadeBase
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

    /**
    * @OneToMany(targetEntity="Pessoa", mappedBy="atividade")
    * @JoinColumn(name="fk_pessoas", referencedColumnName="id", nullable=true)
    */
    protected $pessoas = null;

    /**
    * @ManyToOne(targetEntity="Projeto", inversedBy="atividades")
    */
    protected $projeto = null;


    public function __construct()
    {
        $this->pessoas = new ArrayCollection();
    }

    public function getId()
    {
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function getPessoas()
    {
      return $this->pessoas;
    }

    public function setPessoas($val)
    {
      $this->pessoas[] = $val;
    }

    public function getProjeto()
    {
      return $this->projeto;
    }

    public function setProjeto($val)
    {
      $this->projeto = $val;
    }

   public function __toString()
   {
      return strval("[Class=Atividade" 
	 .", id=".$this->getId()
	 .", Nome=".$this->getNome()
     .", Início=".$this->getDataInicio()
	 .", Fim=".$this->getDataFim()
	 .", percentualFeito=".$this->getPercentualFeito()
	 .", Pessoas=".$this->getPessoas()
	 .", Projeto=".$this->getProjeto()
	 ."]");
   }
}
