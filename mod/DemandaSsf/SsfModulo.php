<?php
namespace Darth\Modules\DemandaSsf;

use Darth\Modules\Fiscalizacao\Mod\ModuloSsfInterface;

class SsfModulo implements ModuloSsfInterface
{
    protected static $nomeModulo = "DemandaSsf";

    public static function getNome()
    {
        return self::$nomeModulo;
    }

    public static function isLigado()
    {
        //try...
        $modStatus = \Darth\Core\Config::get()["modules"][self::$nomeModulo];
        return $modStatus;
    }

    /**
    * @return array
    */
    public static function getDependencias()
    {
        return array();//depende de mod fiscalizacao !
    }

    public static function listarAprovadas()
    {
        //TODO deveria ir num Repository...
        $em = \Darth\Core\dao\DAO::em();
        $demandas = $em->getRepository("Darth\Modules\DemandaSsf\dao\SSF")
            ->findBy(array("okCoordenador" => 1, "okGrUo" => 1, "okFigf" => 1), array("id" => "ASC") );
        
        $afs = array();
        foreach ($demandas as $demanda){
            foreach ($demanda->getAcoesFiscalizacao() as $acao){
                array_push($afs, $acao);
            }
            /*
            //fluxo simplificado com única aprovação:
            //tosqueira para não ter que fazer o Repository na prova de conceito:
            if($demanda->getProjeto()->getStatus() == 2){
                foreach ($demanda->getAcoesFiscalizacao() as $acao){
                    array_push($afs, $acao);
                }
            }
            */
        }
        return $afs;
    }
}
