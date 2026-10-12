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

$tiempoInicio = microtimeFloat();

spl_autoload_register(
    function ($archivo) {
        $prefijo = 'Rutalo\\Tests\\';

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

/**
 * Obtiene la marca de tiempo en microsegundos con decimales.
 * 
 * @return float
 */
function microtimeFloat()
{
    list($useg, $seg) = explode(' ', microtime());

    return ((float) $useg + (float) $seg);
}

/**
 * Obtiene la marca de tiempo empleada en la ejecución.
 * 
 * @return string
 */
function obtenerTiempoEmpleado()
{
    $tiempoFin = microtimeFloat();
    global $tiempoInicio;

    return 'Tiempo empleado: ' . ($tiempoFin - $tiempoInicio);
}

/**
 * Debuguea un elemento sin detener la ejecución.
 * 
 * @return void
 */
function d()
{
    echo obtenerTiempoEmpleado();

    debuguear(...func_get_args());
}

/**
 * Debuguea un elemento deteniendo la ejecución.
 * 
 * @return void
 */
function dd()
{
    echo obtenerTiempoEmpleado();
    debuguear(...func_get_args());

    exit();
}

/**
 * Debuguea un elemento.
 * 
 * @return void
 */
function debuguear()
{
    $argumentos = func_get_args();

    foreach ($argumentos as $argumento) {
        echo "\n";
        var_dump($argumento);
        echo "\n";
    }
}

if (!function_exists('apache_request_headers')) {
    function apache_request_headers()
    {
        $encabezados = [];

        foreach ($_SERVER as $clave => $valor) {
            if (substr($clave, 0, 5) == 'HTTP_') {
                $encabezado = str_replace(
                    ' ', '-', ucwords(
                        str_replace(
                            '_', ' ', strtolower(
                                substr($clave, 5)
                            )
                        )
                    )
                );

                $encabezados[$encabezado] = $valor;
            }
        }

        return $encabezados;
    }
}
