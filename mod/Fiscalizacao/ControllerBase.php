<?php
#namespace Darth\Core\Modules\Fiscalizacao;
namespace Darth\Modules\Fiscalizacao;
#namespace Acme;

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
            \Doctrine\Common\Util\Debug::dump("teste GET");
            //TODO setar o template para __DIR__ . /templates
            $params = array("templates" => $app->view->getTemplatesDirectory() );
            $app->render("home.html", $params );
        });
    }

    
}
