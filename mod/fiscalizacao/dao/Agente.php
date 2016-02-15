<?php
namespace Darth\Core\Modules\Fiscalizacao\dao;

use Darth\Core\DAO\PessoaBase as PessoaBase;

/**
 * Agente poderia herdar de PessoaRJU, PessoaTerceirizada e estes de PessoaBase,
 *  por exemplo a depender do contexto da Agência Reguladora usuária do sistema
 * 
 * @Entity
 * @Table(name="mod_fiscalizacao__agentes")
 */
class Agente extends PessoaBase
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

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


   public function __toString()
   {
      return strval("[Class=Agente" 
     .", id=".$this->getId()
     .", Nome=".$this->getNome()
     .", Matrícula=".$this->getMatricula()
     .", Credencial=".$this->getCredencial()
     ."]");
   }
}
