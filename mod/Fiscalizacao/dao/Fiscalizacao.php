<?php
#namespace Darth\Core\Modules\Fiscalizacao\dao;
namespace Darth\Modules\Fiscalizacao\dao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;

use Darth\Core\dao\ProjetoBase as ProjetoBase;

/**
 * @Entity 
 * @Table(name="mod_fiscalizacao__fiscalizacoes")
 */
class Fiscalizacao #extends ProjetoBase #se herdar os atributos de ProjetoBase são criados nesta entidade. Se usar OneToOne, a entidade Projeto sempre existirá e será completada com esta entidade usando-se um OneToOne
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;


    /** @Column(type="integer") */
    protected $urgencia;

    /**
    * @OneToMany(targetEntity="Agente", mappedBy="fiscalizacao")
    * @JoinColumn(name="fk_agentes", referencedColumnName="id", nullable=true)
    */
    protected $agentes = null;

    /**
    * @OneToOne(targetEntity="Darth\Core\dao\Projeto",cascade={"persist"})
    * @JoinColumn(name="fk_projeto", referencedColumnName="id", nullable=false)
    */
    protected $projeto = null;

    public function __construct()
    {
        $this->agentes = new ArrayCollection();
    }

    public function getId()
    {
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function getUrgencia()
    {
      return $this->urgencia;
    }

    public function setUrgencia($val)
    {
      $this->urgencia = $val;
    }

    public function getAgentes()
    {
      return $this->agentes;
    }

    public function setAgentes($val)
    {
      $this->agentes = $val;
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
      return strval("[Class=Fiscalizacao" 
	 .", id=".$this->getId()
	 .", Urgência=".$this->getUrgencia()
	 .", Agentes=".$this->getAgentes()
	 .", Projeto=".$this->getProjeto()
	 ."]");
   }
}
