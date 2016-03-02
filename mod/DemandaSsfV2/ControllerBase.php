<?php
namespace Darth\Modules\DemandaSsfV2;

use Darth\Modules\DemandaSsfV2\Mod\ParentSsfDelegator;

class ControllerBase #extends \Darth\Core\AbstractModulesController
{
    protected $app; #slim app instance

    public function __construct()
    {   
        $app = \Darth\Core\ControllerHelper::getSlimInstance();
        $app->view->setTemplatesDirectory(__DIR__ . "/templates");
        $app->group('/modules/DemandaSsfV2', function () use ($app) {
            $app->group('/ssf', function () use ($app) {
               $app->get('/', function () use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    $demandas=array();
                    $demandas = $em->getRepository("Darth\Modules\DemandaSsfV2\dao\SSF")
                        ->findBy(array(), array("id" => "ASC") );
                    /*
                    * Prova de Conceito de Módulo Extensível Com Auto Migração:
                    * pela nova regra de negócio, as SSFs que não terminaram o fluxo
                    * de aprovação na v.1 devem ser incluídas como pendentes de aprovação
                    * na v.2, sendo assim, migradas para a nova regra de negócio.
                    */
                    $delegator = new ParentSsfDelegator();
                    $ssfV1 = $delegator->listarPendentesAprovacao(); //tipo de retorno: SsfV1 !!!!
                    //para simplificar, não vou criar instâncias de SsfV2 para cada SsfV1 retornada:
                    //$listaCompleta = array_merge($demandas, $ssfV1);
                    //Criar instâncias de SsfV2 para cada SsfV1 retornada:
                    $listaCompleta = $demandas;
                    foreach ( $ssfV1 as $old ){
                        //migração: vemos as velhas; depois de aprovar elas devem ser movidas da tabela velha para a nova
                        $new = new \Darth\Modules\DemandaSsfV2\dao\SSF();
                        $new->setProjeto($old->getProjeto());
                        $new->setAcoesFiscalizacao($old->getAcoesFiscalizacao());
                        array_push($listaCompleta, $new);
                    }
                    $params = array("demandas" => $listaCompleta
                                    ,"username" => $app->environment["PHP_AUTH_USER"]  );
                    $app->render("ssf.html", $params);
                });
               $app->post('/add', function () use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    $inicio = $app->request->post("inicio");
                    $fim = $app->request->post("fim");
                    $objetivo = $app->request->post("ssfObjetivo");

                    $dataInicio = \DateTime::createFromFormat("d/m/Y", $inicio);
                    $dataFim = \DateTime::createFromFormat("d/m/Y", $fim);
                    
                    $projeto = new \Darth\Core\dao\Projeto();
                    $projeto->setDataInicio($dataInicio);
                    $projeto->setDataFim($dataFim);
                    $projeto->setDescricao($objetivo);
                    $projeto->setNome("SSF v#2");

                    $af = new \Darth\Modules\Fiscalizacao\dao\AcaoFiscalizacao();
                    $af->setProjeto($projeto);

                    $ssf = new dao\SSF();
                    $ssf->setProjeto($projeto);
                    $ssf->setAcoesFiscalizacao( array($af) );
                    

                    $em->persist($ssf);
                    $em->flush();
                });
               $app->get('/aprovar/:ssfId', function ($ssfId) use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    #$ssfId = $app->request->post("ssfId");
                    $ssf = $em->find("Darth\Modules\DemandaSsfV2\dao\SSF", $ssfId);
                    $ssf->getProjeto()->setStatus(2);
                    $em->persist($ssf);
                    $em->flush();
                });
               
            });
        });
    }

    
}
