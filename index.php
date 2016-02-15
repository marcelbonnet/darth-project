<?php
$loader = require_once 'vendor/autoload.php';
#       ERRO: $loader->add("Acme\\", __DIR__ . "/mod/Fiscalizacao"); #não surtiu efeito
#   OK:
#$loader->addPsr4("Acme\\", __DIR__ . "/mod/Fiscalizacao");  #funcionou
#$loader->setUseIncludePath(true);  # dispensável
#print_r($loader->getPrefixesPsr4());   # OK, foi listado
#$loader->addPsr4("Darth\\Modules\\Fiscalizacao\\", __DIR__ . "/mod/Fiscalizacao");  #funcionou
#require_once __DIR__ . "/mod/Fiscalizacao/ControllerBase.php" ; #funciona
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
$app->hook('slim.before', function() use ($app, $loader) {
    #
    # Rotas /modules/... 
    # são reservadas para módulos por causa do bootstrap aqui embutido:
    #   PADRÃO:
    #   diretório de módulos:
    #       [projeto]/mod/[n]ome_modulo
    #   namespace de módulos:
    #       Darth\Modules\[N]ome_modulo

    #preg_match("@^/Modules/.+$@", $app->request->getPathInfo() , $matches);
    preg_match("@^/modules/.+$@", $app->request->getPathInfo() , $matches);
    if($matches){   #print: [0] => /mod/fiscalizacao
        $nomeModulo = explode("/",$matches[0])[2];
        $modNamespace = ucfirst($nomeModulo);
        # TESTE 1
        #require_once __DIR__ . $matches[0] . "/ControllerBase.php"; #dá erro nesse include, classe dentro de método hook!
        
        # TESTE 2
        #$ctrl = new \Darth\Core\Modules\Fiscalizacao\ControllerBase(); #class not found, problema no config do composer?

        # TESTE 3
        #$loader->addPsr4("Darth\\Modules\\Fiscalizacao\\", __DIR__ . "/mod/fiscalizacao");  #funcionou
        $loader->addPsr4("Darth\\Modules\\". $modNamespace ."\\", __DIR__ . "/mod/" . $nomeModulo);
        $ctrl = new Darth\Modules\Fiscalizacao\ControllerBase();
        #$app->render("home.html", array("teste" => $nomeModulo ) );
    }
    
});

//Compartilha a instância para os módulos
\Darth\Core\ControllerHelper::setSlimInstance($app);
$app->run();
