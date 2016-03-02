<?php
namespace Darth\Modules\DemandaSsfV2;

use Darth\Modules\Fiscalizacao\Mod\ModuloSsfInterface;

class SsfModuloV2 implements ModuloSsfInterface
{
    protected static $nomeModulo = "DemandaSsfV2";

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

    public static function onBootstrap()
    {
        //todo
    }

    public static function onDesacoplar()
    {
        //todo
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
