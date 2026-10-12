<?php

/**
 * Este archivo es parte del proyecto Rutalo.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2026 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  1.0.0
 * @link      https://rutalo.proes.io
 * @since     Fecha inicio de creación del proyecto  2026-06-03
 */

spl_autoload_register(
    function ($archivo) {
        $prefijo = 'Rutalo\\';

        $prefijoLongitud = strlen($prefijo);

        if (strncmp($archivo, $prefijo, $prefijoLongitud) === 0) {
            $ruta = str_replace('\\', '/', $archivo);
            $ruta = substr($ruta, $prefijoLongitud);
            $ruta = __DIR__ . '/' . $ruta . '.php';

            if (file_exists($ruta)) {
                include_once $ruta;
            }
        }
    }
);
