<?php
// cli-config.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

/* ao carregar novo ou mudar staus de um módulo
* registrar isso numa classe/tabela core-modules do
* sistema para saber onde dar o bootstrap:
*/

$paths = array( __DIR__ . "/src/dao/",
        # usar  . DIRECTORY_SEPARATOR . 
                __DIR__ . "/mod/fiscalizacao/dao"   #no cli-config é direto, no DAO.php tem que usar "../../mod"
        );    //"./src/dao" , path to Managed Entities
#$paths = array(__DIR__ . "/src/dao");    // path to Managed Entities

$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'    => "pdo_mysql",
    'user'      => "marcelbonnet",
    'password'  => "",
    'host'      => "localhost",
    'dbname'    => "darth_project",
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($em);
