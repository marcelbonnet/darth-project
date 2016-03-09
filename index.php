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

//	Setup	Whoops	error	and	exception	handlers
$whoops	=	new	\Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();


$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "path" => "/",
    "realm" => "Darth Project",
    "secure" => false,  #para poder acessar pela rede!
    "relaxed" => ["localhost", "marcelbonnet.org"],
    "users" => [
        "root" => "toor",
        "user" => "user"
    ],
    "authenticator" => function ($arguments) use ($app) {
        return (bool)false; //não teve efeito !?!?
    }
    /* v.2 ,
    "error" => function ($request, $response, $arguments) use ($app) {
        $data = [];
        $data["status"] = "Erro ao autenticar em Darth Project.";
        $data["message"] = $arguments["message"];
        return $response->write(json_encode($response, JSON_UNESCAPED_SLASHES));
    }*/
    , /*v.1.0.0*/
    "error" => function ($arguments) use ($app) {
        $response["status"] = "error";
        $response["message"] = $arguments["message"];
        $app->response->write(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
]));

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


//mais teste hard coded do ServiceLocator de Módulos:
//estado inicial dos módulos
/*
* simulação: usuário importa ou descompacta o mod no apache, ou ambos?
* lê do banco de dados ou do diretório mod?
*/
/*
$modSsf = new \Darth\Core\mod\Modulo();
$modSsf->setNome("SSF");
$modSsf->setEstado(true);
*/
/*
$modFocus = new \Darth\Core\mod\Modulo();
$modFocus->setNome("FOCUS");
$modFocus->setEstado(true);
*/
#\Darth\Core\ServiceLocator::add('\Darth\Core\Modules\DemandaSsf');

$app->group('/admin', function () use ($app) {
   $app->group('/modules', function () use ($app) {
       $app->get('/', function () use ($app) {
            /*
            * simulação: usuário importa ou descompacta o mod no apache, ou ambos?
            * lê do banco de dados ou do diretório mod?
            */
            $modulos = array(); //de \Darth\Core\mod\ModuloInterface
            
            /*
            #$modulos["\Darth\Modules\DemandaSsf\SsfModulo"] = new \Darth\Modules\DemandaSsf\SsfModulo();
            \Darth\Core\ServiceLocator::getInstance()->add(
                    "Darth\Modules\DemandaSsf\SsfModulo"
                    ,new \Darth\Modules\DemandaSsf\SsfModulo()
                    ,true
                    );

            //obtém os serviços registrados:
            $interfaces = \Darth\Core\ServiceLocator::getInstance()->getInterfaces();
            foreach ($interfaces as $interface){
                #\Darth\Core\mod\ModuloInterface
                $instancia = \Darth\Core\ServiceLocator::getInstance()->get($interface);
                $modulos[$interface] = $instancia;
            }
            */
          
            \Doctrine\Common\Util\Debug::dump( Darth\Core\ServiceLocator::getInstance()->getInterfaces() );
            
            $params = array("modulos"=> $modulos);
            $app->render("admin/modules.html", $params);
        });
       $app->get('/teste', function () use ($app) {
            \Doctrine\Common\Util\Debug::dump( Darth\Core\ServiceLocator::getInstance()->getInterfaces() );
            
        });
       $app->get('/:string', function ($nomeModulo) use ($app) {
            //alterar direto no config.ini para testar
            
        });
    });
});

/*
 * carrega controllers dos módulos
* TROCAR POR UM MIDDLEWARE:
*/
$app->hook('slim.before', function() use ($app, $loader) {
$af = new \Darth\Modules\Fiscalizacao\dao\AcaoFiscalizacao();
//TROCAR OS CAMINHOS FÍSICOS PARA O PADRÃO Slim:
//src/Mod/Fiscalizacao
//src/Mod/DemandasSsf
//não está certo ficar traduzindo o que o PSR-4 faz

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
        #com minúscula, errado vou corrigir para usar como no Slim (inicial do dir é maiúscula)
        #$loader->addPsr4("Darth\\Modules\\". $modNamespace ."\\", __DIR__ . "/mod/" . $nomeModulo);
        #desnecessário, o psr-4 faz sozinho:
        #$loader->addPsr4("Darth\\Modules\\". $nomeModulo ."\\", __DIR__ . "/mod/" . $nomeModulo);

        #$ctrl = new Darth\Modules\Fiscalizacao\ControllerBase();
        #$moduleBootstrapClass = "Darth\\Modules\\".$modNamespace."\\ControllerBase";
        $moduleBootstrapClass = "Darth\\Modules\\".$nomeModulo."\\ControllerBase";

        $modStatus = Darth\Core\Config::get()["modules"][$nomeModulo];
        if ( ! $modStatus ) {
            //e como evitar que um mod use outro mod que foi desativado?
            $app->response->headers->set('Content-Type','text/html; charset=utf-8');
            $app->halt(500,"O módulo $nomeModulo está desativado.");
        } else
            $ctrl = new $moduleBootstrapClass();

        # TESTE 1
        #require_once __DIR__ . $matches[0] . "/ControllerBase.php"; #dá erro nesse include, classe dentro de método hook!
        
        # TESTE 2
        #$ctrl = new \Darth\Core\Modules\Fiscalizacao\ControllerBase(); #class not found, problema no config do composer?

        # TESTE 3
        #$loader->addPsr4("Darth\\Modules\\Fiscalizacao\\", __DIR__ . "/mod/fiscalizacao");  #funcionou
        #$loader->addPsr4("Darth\\Modules\\". $modNamespace ."\\", __DIR__ . "/mod/" . $nomeModulo);
        #$ctrl = new Darth\Modules\Fiscalizacao\ControllerBase();
        #$app->render("home.html", array("teste" => $nomeModulo ) );
    }
    
});

/*
 * INJEÇÃO DE DEPENDÊNCIA
 * TODO: http://pimple.sensiolabs.org/ , parece que está no Slim 3 !
 */
//workaround:
//Compartilha a instância (ServiceLocator, Módulos... haveria outra forma, para proteger o encapsulamento?)
\Darth\Core\ControllerHelper::setSlimInstance($app);

#\Darth\Core\ControllerHelper::$serviceLocator = \Darth\Core\ServiceLocator::getInstance(); #reinstancia sempre

//PROBLEMA COM DI:
//Teste por injeção de dependência para não quebrar encapsulamento:
//funções podem ser passadas por referência (http://php.net/manual/en/language.references.pass.php)
//$env = function &() use($app) { $a=$app->environment(); return $a;};
/*
    //PHP Notice : Indirect modification of overloaded element of Slim\Environment has no effect in
    //sempre que outra classe fizer $envServices()
$envServices = function &() use($app) { return $app->environment()["darth.servicelocator.services"]; };
$envInstantiated = function &() use($app) { return $app->environment()["darth.servicelocator.instantiated"]; };
$envShared = function &() use($app) { return $app->environment()["darth.servicelocator.shared"]; };
\Darth\Core\ServiceLocator::getInstance()->setEnv($env);
\Darth\Core\ServiceLocator::getInstance()->setServices($envServices);
\Darth\Core\ServiceLocator::getInstance()->setInstantiated($envInstantiated);
\Darth\Core\ServiceLocator::getInstance()->setShared($envShared);
*/
//PHP Notice : Indirect modification of overloaded element of Slim\Environment has no effect in
/*
\Darth\Core\ServiceLocator::getInstance()->setServices($app->environment()["darth.servicelocator.services"]);
\Darth\Core\ServiceLocator::getInstance()->setInstantiated($app->environment()["darth.servicelocator.instantiated"]);
\Darth\Core\ServiceLocator::getInstance()->setShared($app->environment()["darth.servicelocator.shared"]);
*/



$app->run();
