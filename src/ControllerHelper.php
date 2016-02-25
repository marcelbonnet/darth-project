<?php
namespace Darth\Core;

class ControllerHelper
{
    private static $slimInstance;

    public static $serviceLocator;

    public static function getSlimInstance()
    {
        return self::$slimInstance;
    }

    public static function setSlimInstance(\Slim\Slim $app)
    {
        self::$slimInstance = $app;
    }
}
