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
 * @MappedSuperclass 
 */
class ProjetoBase
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

    /**
    * @OneToMany(targetEntity="ProjetoBase", mappedBy="parent")
    */
    protected $children = null;

    /**
    * @ManyToOne(targetEntity="ProjetoBase", inversedBy="children")
    */
    protected $parent = null;

    /**
    * @OneToMany(targetEntity="AtividadeBase", mappedBy="projeto")
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
   
}
