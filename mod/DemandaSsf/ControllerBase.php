<?php
namespace Darth\Modules\DemandaSsf;

class ControllerBase #extends \Darth\Core\AbstractModulesController
{
    protected $app; #slim app instance

    public function __construct()
    {   
        $app = \Darth\Core\ControllerHelper::getSlimInstance();
        $app->view->setTemplatesDirectory(__DIR__ . "/templates");
        $app->group('/modules/DemandaSsf', function () use ($app) {
            $app->group('/ssf', function () use ($app) {
               $app->get('/', function () use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    $demandas=array();
                    $demandas = $em->getRepository("Darth\Modules\DemandaSsf\dao\SSF")
                        ->findBy(array(), array("id" => "ASC") );
                    $params = array("demandas" => $demandas
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
                    $projeto->setNome("SSF");   #na modelagem com herança ou OneToOne, fiquei com esse problema! deveria ser not null? não deveria herdar?

                    $af = new \Darth\Modules\Fiscalizacao\dao\AcaoFiscalizacao();
                    $af->setProjeto($projeto);

                    $ssf = new dao\SSF();
                    $ssf->setProjeto($projeto);
                    $ssf->setAcoesFiscalizacao( array($af) );
                    

                    $em->persist($ssf);
                    $em->flush();
                });
               $app->get('/ssf2af/:ssfId', function ($ssfId) use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    #$ssfId = $app->request->post("ssfId");
                    $ssf = $em->find("Darth\Modules\DemandaSsf\dao\SSF", $ssfId);
                    $ssf->getProjeto()->setStatus(2);
                    $em->persist($ssf);
                    $em->flush();
                });
            });
        });
    }

    
}
