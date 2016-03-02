<?php
namespace Darth\Core\mod;

interface ModuloEvent
{
    /**
    * Evento disparado quando o módulo for habilitado 
    * (no painel de administração, por exemplo)
    */
    public static function onBootstrap();

    /**
    * Evento disparado quando o módulo for desabilitado 
    * (no painel de administração, por exemplo)
    */
    public static function onDesacoplar();

}
