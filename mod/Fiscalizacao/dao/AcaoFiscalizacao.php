<?php
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
 * @Table(name="mod_fiscalizacao__af")
 */
class AcaoFiscalizacao
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


    //OneToOne: Entidade (se houver somente entidade, sem estações)
    //OneToMany: Estações(->getEntidade), Localidade, Faixa de Freq
    //OneToOne: Demandante, Denunciante, Solicitante, Tema, Servico


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
      return strval("[Class=AcaoFiscalizacao" 
	 .", id=".$this->getId()
	 .", Início=".$this->getProjeto()->getDataInicio()->format("d/m/Y")
	 .", Fim=".$this->getProjeto()->getDataFim()->format("d/m/Y")
     .", Objetivo=".$this->getProjeto()->getDescricao()
     .", Status=".$this->getProjeto()->getStatus()
	 ."]");
   }
}
