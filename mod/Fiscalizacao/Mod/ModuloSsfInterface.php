<?php
namespace Darth\Modules\Fiscalizacao\Mod;

use Darth\Core\mod\ModuloInterface;

interface ModuloSsfInterface extends ModuloInterface
{
    public static function listarAprovadas(); //simula as que foram aprovadas por todos os envolvidos
}
