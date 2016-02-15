<?php
namespace Darth\Core\Modules\Fiscalizacao\dao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;

use Darth\Core\DAO\ProjetoBase as ProjetoBase;

/**
 * @Entity 
 * @Table(name="mod_fiscalizacao__fiscalizacoes")
 */
class Fiscalizacao extends ProjetoBase
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;


    /** @Column(type="integer") */
    protected $urgencia;


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

    public function getUrgencia()
    {
      return $this->urgencia;
    }

    public function setUrgencia($val)
    {
      $this->urgencia = $val;
    }

    
   public function __toString()
   {
      return strval("[Class=Fiscalizacao" 
	 .", id=".$this->getId()
	 .", Nome=".$this->getNome()
	 .", Início=".$this->getDataInicio()
	 .", Fim=".$this->getDataFim()
	 .", Urgência=".$this->getUrgencia()
	 ."]");
   }
}
