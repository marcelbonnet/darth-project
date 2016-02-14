<?php
namespace Darth\Core\DAO;

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
class Atividade
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

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

    /** @Column(type="integer") */
    protected $percentualFeito;

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

    public function getPercentualFeito()
    {
      return $this->percentualFeito;
    }

    public function setPercentualFeito($val)
    {
      $this->percentualFeito = $val;
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
