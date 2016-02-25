<?php
namespace Darth\Modules\Fiscalizacao\dao;

#use Darth\Core\dao\PessoaBase as PessoaBase;

/**
 * Agente poderia herdar de PessoaRJU, PessoaTerceirizada e estes de PessoaBase,
 *  por exemplo a depender do contexto da Agência Reguladora usuária do sistema
 * 
 * @Entity
 * @Table(name="mod_fiscalizacao__agentes")
 */
class Agente #extends PessoaBase
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

    /**
    * @OneToOne(targetEntity="Darth\Core\dao\Pessoa",cascade={"persist"})
    * @JoinColumn(name="fk_pessoa", referencedColumnName="id", nullable=false)
    */
    protected $pessoa;

    /** @Column(type="integer") */
    protected $credencial;

    /**
    * @ManyToOne(targetEntity="Fiscalizacao", inversedBy="agentes")
    */
    protected $fiscalizacao = null;

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

    public function getFiscalizacao()
    {
      return $this->fiscalizacao;
    }

    public function setFiscalizacao($val)
    {
      $this->fiscalizacao = $val;
    }

    public function getCredencial()
    {
      return $this->credencial;
    }

    public function setCredencial($val)
    {
      $this->credencial = $val;
    }

    public function getPessoa()
    {
      return $this->pessoa;
    }

    public function setPessoa($val)
    {
      $this->pessoa = $val;
    }


   public function __toString()
   {
      return strval("[Class=Agente" 
     .", id=".$this->getId()
     #.", Nome=".$this->getNome()
     #.", Matrícula=".$this->getMatricula()
     .", Credencial=".$this->getCredencial()
     .", Pessoa=".$this->getPessoa()
     ."]");
   }
}
