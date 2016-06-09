<?php

namespace Jmap;

class Config
{

    public static function db($nameDb)
    {
        $data = require __DIR__.'/../../../config/autoload/local.php';

        if(!isset($data['db'])){
            throw new \Exception('No existe la configuracion de la base de datos');
        }

        if(!isset($data['db'][$nameDb])){
            throw new \Exception('No existe la configuracion de la bse de datos : '.$nameDb);
        }
        return $data['db'][$nameDb];
    }

    public static function crypt($nameCrypt)
    {
        $data = require __DIR__.'/../../../config/autoload/local.php';

        if(!isset($data['crypt'])){
            throw new \Exception('No existe la configuracion para la encriptacion');
        }
        if(!isset($data['crypt'][$nameCrypt])){
            throw new \Exception('No existe la configuracion para la encriptacion : '.$nameCrypt);
        }
        if(trim($data['crypt'][$nameCrypt])==''){
            throw new \Exception('La cadena de encriptacion '.$nameCrypt.' no puede estar vacia');
        }
        return $data['crypt'][$nameCrypt];
    }
    
}
