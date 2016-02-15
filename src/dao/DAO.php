<?php
namespace Darth\Core\dao;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DAO
{
   public static function em()
    {
        /* ao carregar novo ou mudar staus de um módulo
        * registrar isso numa classe/tabela core-modules do
        * sistema para saber onde dar o bootstrap:
        */
        
        $paths = array( __DIR__,
                # usar  . DIRECTORY_SEPARATOR . 
                        __DIR__ . "/../mod/Fiscalizacao/dao"
                );    //"./src/dao" , path to Managed Entities
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

        return $em;
    }
   
}
    
