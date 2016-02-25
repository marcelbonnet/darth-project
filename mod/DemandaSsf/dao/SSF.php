<?php
namespace Darth\Modules\DemandaSsf\dao;

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
 * @Table(name="mod_demanda_ssf__ssf")
 */
class SSF
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

    /**
    * @OneToOne(targetEntity="Darth\Core\dao\Projeto",cascade={"persist"})
    * @JoinColumn(name="fk_projeto", referencedColumnName="id", nullable=false)
    */
    protected $projeto;

    /**
    * @ManyToMany(targetEntity="Darth\Modules\Fiscalizacao\dao\AcaoFiscalizacao"
    *       ,cascade={"persist"}
    *       )
    * @JoinTable(name="mod_demanda_ssf__ssf_af",
    *      joinColumns={@JoinColumn(name="fk_ssf", referencedColumnName="id")},
    *      inverseJoinColumns={@JoinColumn(name="fk_af", referencedColumnName="id")}
    *      )
    */
    protected $acoesFiscalizacao;


    public function __construct()
    {
        $this->acoesFiscalizacao = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
    * getter auto gerado
    * @return id 
    */
    public function getId() {
        return $this->id;
    }
    /**
    * setter auto gerado
    * @param id 
    */
    public function setId($id) {
        $this->id=$id;
    }
    /**
    * getter auto gerado
    * @return projeto 
    */
    public function getProjeto() {
        return $this->projeto;
    }
    /**
    * setter auto gerado
    * @param projeto 
    */
    public function setProjeto($projeto) {
        $this->projeto=$projeto;
    }
    /**
    * getter auto gerado
    * @return acoesFiscalizacao 
    */
    public function getAcoesFiscalizacao() {
        return $this->acoesFiscalizacao;
    }
    /**
    * setter auto gerado
    * @param acoesFiscalizacao 
    */
    public function setAcoesFiscalizacao($acoesFiscalizacao) {
        $this->acoesFiscalizacao=$acoesFiscalizacao;
    }  
    

    public function __toString()
    {
      return strval("[Class=SFF" 
     .", id=".$this->getId()
     .", Início=".$this->getProjeto()->getDataInicio()->format("d/m/Y")
     .", Fim=".$this->getProjeto()->getDataFim()->format("d/m/Y")
     .", Objetivo=".$this->getProjeto()->getDescricao()
     .", Status=".$this->getProjeto()->getStatus()
     ."]");
    }
}
