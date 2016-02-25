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

    //simular SSF workflow #1

    /**
     * @Column(type="smallint")
    */
    protected $okCoordenador = 0;

    /**
     * @Column(type="smallint")
    */
    protected $okFigf = 0;

    /**
     * @Column(type="smallint")
    */
    protected $okGrUo = 0;


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
    
    /**
    * getter auto gerado
    * @return okCoordenador 
    */
    public function getOkCoordenador() {
        return $this->okCoordenador;
    }
    /**
    * setter auto gerado
    * @param okCoordenador 
    */
    public function setOkCoordenador($okCoordenador) {
        $this->okCoordenador=$okCoordenador;
    }
    /**
    * getter auto gerado
    * @return okFigf 
    */
    public function getOkFigf() {
        return $this->okFigf;
    }
    /**
    * setter auto gerado
    * @param okFigf 
    */
    public function setOkFigf($okFigf) {
        $this->okFigf=$okFigf;
    }
    /**
    * getter auto gerado
    * @return okGrUo 
    */
    public function getOkGrUo() {
        return $this->okGrUo;
    }
    /**
    * setter auto gerado
    * @param okGrUo 
    */
    public function setOkGrUo($okGrUo) {
        $this->okGrUo=$okGrUo;
    }

    public function __toString()
    {
      return strval("[Class=SFF" 
     .", id=".$this->getId()
     .", Início=".$this->getProjeto()->getDataInicio()->format("d/m/Y")
     .", Fim=".$this->getProjeto()->getDataFim()->format("d/m/Y")
     .", Objetivo=".$this->getProjeto()->getDescricao()
     .", Status=".$this->getProjeto()->getStatus()
     .", OkCoordenador=". $this->_okLabel($this->getOkCoordenador())
     .", OkGrUo=".$this->_okLabel($this->getOkGrUo())
     .", OkFigf=".$this->_okLabel($this->getOkFigf())
     ."]");
    }

    private function _okLabel($num)
    {
        switch ($num) {
            case 0;
                return "Pendente de Análise";
            break;
            case 1;
                return "Aprovada";
            break;
            case 2;
                return "Reprovada";
            break;
            default :
                return $num;
            break;
        }
        
    }
}
