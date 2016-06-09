<?php

namespace SkeletonModule\Util;

class Route {
    private static $ruta;
    public static function set($ruta) { 
        self::$ruta = $ruta; 
    }
    public static function get() { 
        return self::$ruta; 
    }
}