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
                    
                    $pessoas = $em->getRepository("\Darth\Core\dao\Pessoa")
                        ->findBy(array(), array("nome" => "ASC") );

                    $lista = $em->getRepository("Darth\Modules\Fiscalizacao\dao\Agente")
                        ->findBy(array(), array("id" => "ASC") );
                    $params = array("pessoas" => $pessoas, "agentes" => $lista);
                    $app->render("agente.html", $params);
                });
               $app->post('/add', function () use ($app) {
                    $em = \Darth\Core\dao\DAO::em();

                    $nome = $app->request->post("nome");
                    $matricula = $app->request->post("matricula");
                    $credencial = $app->request->post("credencial");

                    //o mapeamento definiu que um Agente DEVE ser uma PESSOA:

                    $pessoa = new \Darth\Core\dao\Pessoa();
                    $pessoa->setNome($nome);
                    $pessoa->setMatricula($matricula);

                    $agente = new dao\Agente();
                    $agente->setPessoa($pessoa);
                    $agente->setCredencial($credencial);

                    $em->persist($agente);
                    $em->flush();
                });
            });
        });
    }

    
}
