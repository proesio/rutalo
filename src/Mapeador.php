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

namespace Rutalo;

use Closure;
use Rutalo\Peticion;
use Rutalo\Excepciones\MetodoHttpNoSoportadoExcepcion;

class Mapeador
{
    /**
     * Mapea las rutas utilizando los métodos HTTP.
     * 
     * @param string $metodo            metodo
     * @param mixed  $accion            accion
     * @param array  $parametros        parametros
     * @param bool   $parametroConsulta parametroConsulta
     * 
     * @return mixed
     * 
     * @throws \Rutalo\Excepciones\MetodoHttpNoSoportadoExcepcion
     */
    public static function mapear($metodo, $accion, $parametros, $parametroConsulta)
    {
        if (in_array($metodo, ['GET', 'DELETE'])
            || ($metodo == 'POST' && in_array($_POST['_metodo'] ?? '', ['DELETE']))
        ) {
            if ($accion instanceof Closure) {
                if ($parametros && $parametroConsulta) {
                    return $accion(new Peticion(), ...$parametros);
                } elseif ($parametroConsulta) {
                    return $accion(new Peticion());
                } elseif ($parametros) {
                    return $accion(...$parametros);
                }

                return $accion();
            } elseif (is_array($accion)) {
                if ($parametros && $parametroConsulta) {
                    return $accion[0]->{$accion[1]}(new Peticion(), ...$parametros);
                } elseif ($parametroConsulta) {
                    return $accion[0]->{$accion[1]}(new Peticion());
                } elseif ($parametros) {
                    return $accion[0]->{$accion[1]}(...$parametros);
                }

                return $accion[0]->{$accion[1]}();
            }
        } elseif (in_array($metodo, ['POST', 'PUT', 'PATCH'])
            || ($metodo == 'POST' && in_array(
                $_POST['_metodo'] ?? '', ['PUT', 'PATCH']
            ))
        ) {
            if ($accion instanceof Closure) {
                return $parametros
                    ? $accion(new Peticion(), ...$parametros)
                    : $accion(new Peticion());
            } elseif (is_array($accion)) {
                return $parametros
                    ? $accion[0]->{$accion[1]}(new Peticion(), ...$parametros)
                    : $accion[0]->{$accion[1]}(new Peticion());
            }
        } else {
            throw new MetodoHttpNoSoportadoExcepcion(
                'Método HTTP no soportado.'
            );
        } 
    }
}
