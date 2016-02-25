<?php
namespace Darth\Core\mod;

interface ModuloInterface 
{
    public static function getNome();
    //getVersao();
    public static function isLigado();
    /**
    * @return array
    */
    public static function getDependencias(); //para não deixar desligar dependências e, ao mesmo tempo, saber qual módulo ele estende (SSF v2 estende interface de SSF v1)
}
