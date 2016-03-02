<?php
namespace Darth\Modules\DemandaSsf\Mod;

/**
 * Interface para estender este Módulo.
 * Cada módulo deve prover uma, inicialmente vazia. 
 * Quando houver a necessidade
 * de criar uma extensão, os métodos deste Helper Delegator devem ser preenchidos
 * para delegar as operações.
 */
//class Delegator //não é um delegator? pois ele vai fazer mais do que apenas chamar outro, vai fazer processamento para poder adaptar o velho ao novo
#class Delegate implements Darth\Modules\DemandaSsf\Interface\DelegateInterface
class Delegate implements DelegateInterface
{
    public function __construct()
    {    
        
    }

    /**
    * @return Darth\Modules\DemandaSsf\dao\SSF array de SSFs
    */
    public function listarPendentesAprovacao()
    {
        //TODO deveria ir num Repository...
        $em = \Darth\Core\dao\DAO::em();
        $demandas = $em->getRepository("Darth\Modules\DemandaSsf\dao\SSF")
            ->findBy(array("okFigf" => 0), array("id" => "ASC") );
        return $demandas;
    }

/* implementar com o advento do novo módulo os métodos que ele precisar
 * para interoperar com o antigo, Ex.:
* 
* public function listarPendentesAprovacao() : Darth\Modules\DemandaSsf\dao\SSF
* 
* public function aprovar(Darth\Modules\DemandaSsf\dao\SSF $ssf, \User $user) : boolean
* public function reprovar(Darth\Modules\DemandaSsf\dao\SSF $ssf) : boolean
* public function cancelar(Darth\Modules\DemandaSsf\dao\SSF $ssf) : boolean
*/
}


/*
 * Ssf\Interface\DelegateInterface
*  Ssf\Interface\Delegate (implements  Ssf\Interface\DelegateInterface precisa disso ????)
* 
* no módulo novo:
* class Delegator 
* 
* __construct( Ssf\Interface\DelegateInterface $delegate)
* 
*  os métodos de consulta ao mód  ssf v.1 podem ser limitados por operações
*  feitas via cron, onBootstrap() ou sei lá que o mod v2 saiba que não existe 
* mais necessidade de certas consultas no v.1 (pq o processo foi migrado... sei lá)
* 
* 
 */
