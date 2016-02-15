<?php
require_once 'vendor/autoload.php';

/*
 *      FRONT CONTROLLER SIMPLIFICADO DE EXEMPLO
 * Omitidos comentários e configs relativos a sessão, auth/authz,
 * cache, opcionais de outros projetos ... etc
 **/

#use \Financa\Cmd as Cmd;

session_cache_limiter(false);
session_start();

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));

$view = $app->view();

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

$app->get('/', function () use ($app) {
    $app->render("home.html");
});

$app->group('/pessoa', function () use ($app) {
   $app->get('/', function () use ($app) {
        $em = \Darth\Core\dao\DAO::em();
        $lista = $em->getRepository("\Darth\Core\dao\Pessoa")
            ->findBy(array(), array("nome" => "ASC") );
        $params = array("pessoas" => $lista);
        $app->render("pessoa_list.html", $params);
    });
   $app->post('/add', function () use ($app) {
        $em = \Darth\Core\dao\DAO::em();

        $nome = $app->request->post("nome");
        $matricula = $app->request->post("matricula");

        $pessoa = new \Darth\Core\dao\Pessoa();
        $pessoa->setNome($nome);
        $pessoa->setMatricula($matricula);

        $em->persist($pessoa);
        $em->flush();
    });
});

$app->group('/projeto', function () use ($app) {
   $app->get('/', function () use ($app) {
        $em = \Darth\Core\dao\DAO::em();
        $lista = $em->getRepository("\Darth\Core\dao\Projeto")
            ->findBy(array(), array("dataInicio" => "ASC") );
        $params = array("projetos" => $lista);
        $app->render("projeto.html", $params);
    });
   $app->post('/add', function () use ($app) {
        $em = \Darth\Core\dao\DAO::em();

        $nome = $app->request->post("nome");
        $inicio = $app->request->post("inicio");
        $fim = $app->request->post("fim");

        $dataInicio = \DateTime::createFromFormat("d/m/Y", $inicio);
        $dataFim = \DateTime::createFromFormat("d/m/Y", $fim);

        $projeto = new \Darth\Core\dao\Projeto();
        $projeto->setNome($nome);
        $projeto->setDataInicio($dataInicio);
        $projeto->setDataFim($dataFim);

        $em->persist($projeto);
        $em->flush();
    });
});

//carrega controllers dos módulos
$app->hook('slim.before', function() use ($app) {
    #
    # Rotas /mod/... 
    # são reservadas para módulos por causa do bootstrap aqui embutido:
    #
    #preg_match("@^/Modules/.+$@", $app->request->getPathInfo() , $matches);
    preg_match("@^/mod/.+$@", $app->request->getPathInfo() , $matches);
    if($matches){   #print: [0] => /mod/fiscalizacao
        #$nomeModulo = explode("/",$matches[0])[2];
        #Darth\Core\Modules\$nomeModulo\Xxxxxxx(); #funciona?
        
        # TESTE 1
        #require __DIR__ . $matches[0] . "/ControllerBase.php"; #dá erro nesse include, classe dentro de método hook!
        
        # TESTE 2
        $ctrl = new \Darth\Core\Modules\Fiscalizacao\ControllerBase();
        
    }
});

//Compartilha a instância para os módulos
\Darth\Core\ControllerHelper::setSlimInstance($app);
$app->run();
