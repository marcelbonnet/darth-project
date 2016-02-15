<?php
namespace Darth\Core\Modules\Fiscalizacao;

class ControllerBase #extends \Darth\Core\AbstractModulesController
{
    protected $app; #slim app instance

    public function __construct()
    {    
        $this->app = \Darth\Core\ControllerHelper::getSlimInstance();
        # teste:
        $this->app->get('/mod/fiscalizacao/teste', function () use ($app) {
            $app->render("home.html");
        });
    }

    
}
