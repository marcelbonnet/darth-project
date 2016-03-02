<?php
namespace Darth\Modules\DemandaSsfV2\Mod;

/**
 * Delega as operações necessárias ao Delegate do módulo com o qual
 * deve trocar mensagens
 */
class ParentSsfDelegator implements \Darth\Modules\DemandaSsf\Mod\DelegateInterface
{
    protected $delegate = null;

    public function __construct()
    {    
        $this->delegate = new \Darth\Modules\DemandaSsf\Mod\Delegate();
    }

    public function listarPendentesAprovacao()
    {
        return $this->delegate->listarPendentesAprovacao();
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
