<?php
namespace Darth\Modules\Fiscalizacao;

class ControllerBase #extends \Darth\Core\AbstractModulesController
{
    protected $app; #slim app instance

    public function __construct()
    {   
        #$this->app = \Darth\Core\ControllerHelper::getSlimInstance();
        $app = \Darth\Core\ControllerHelper::getSlimInstance();
        # teste:
        $app->view->setTemplatesDirectory(__DIR__ . "/templates");
        
        #$this->app->get('/mod/fiscalizacao/teste', function () use ($app) {
        #TODO: $app->group("/modules/fiscalizacao") ...
        $app->get('/modules/fiscalizacao/teste', function () use ($app) {
            #\Doctrine\Common\Util\Debug::dump("teste GET");
            //TODO setar o template para __DIR__ . /templates
            $params = array("templates" => $app->view->getTemplatesDirectory() );
            $app->render("home.html", $params );
        });

        $app->group('/modules/fiscalizacao', function () use ($app) {
            $app->group('/agente', function () use ($app) {
               $app->get('/', function () use ($app) {
                    $em = \Darth\Core\dao\DAO::em();
                    $lista = $em->getRepository("Darth\Modules\Fiscalizacao\dao\Agente")
                        ->findBy(array(), array("nome" => "ASC") );
                    $params = array("agentes" => $lista);
                    $app->render("agente.html", $params);
                });
               $app->post('/add', function () use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    $nome = $app->request->post("nome");
                    $matricula = $app->request->post("matricula");
                    $credencial = $app->request->post("credencial");

                    $agente = new dao\Agente();
                    $agente->setNome($nome);
                    $agente->setMatricula($matricula);
                    $agente->setCredencial($credencial);

                    $em->persist($agente);
                    $em->flush();
                });
            });
        });
    }

    
}
