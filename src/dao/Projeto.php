<?php
namespace Darth\Core\dao;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="core__projetos")
 */
class Projeto extends ProjetoBase
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var integer
    */
    protected $id;

    /**
    * @OneToMany(targetEntity="Projeto", mappedBy="parent")
    */
    protected $children = null;

    /**
    * @ManyToOne(targetEntity="Projeto", inversedBy="children")
    */
    protected $parent = null;

    /**
    * @OneToMany(targetEntity="Atividade", mappedBy="projeto")
    * @JoinColumn(name="fk_atividades", referencedColumnName="id", nullable=true)
    */
    protected $atividades = null;

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

    public function getChildren()
    {
      return $this->children;
    }

    public function setChildren($val)
    {
      $this->children[] = $val;
    }

    public function getParent()
    {
      return $this->parent;
    }

    public function setParent($val)
    {
      $this->parent = $val;
    }


    public function getAtividades()
    {
      return $this->atividades;
    }

    public function setAtividades($val)
    {
      $this->atividades = $val;
    }

   public function __toString()
   {
      return strval("[Class=Projeto" 
	 .", id=".$this->getId()
	 .", Nome=".$this->getNome()
	 .", Início=".$this->getDataInicio()->format("d/m/Y")
	 .", Fim=".$this->getDataFim()->format("d/m/Y")
	 ."]");
   }
}
