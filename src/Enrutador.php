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
use Rutalo\Mapeador;
use Rutalo\Excepciones\AccionNoSoportadaExcepcion;
use Rutalo\Excepciones\ClaseNoEncontradaExcepcion;
use Rutalo\Excepciones\MetodoNoEncontradoExcepcion;

class Enrutador
{
    /**
     * Enruta los métodos HTTP.
     * 
     * @param string $metodo metodo
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return array
     * 
     * @throws \Rutalo\Excepciones\AccionNoSoportadaExcepcion
     * @throws \Rutalo\Excepciones\ClaseNoEncontradaExcepcion
     * @throws \Rutalo\Excepciones\MetodoNoEncontradoExcepcion
     */
    public static function enrutar($metodo, $ruta, $accion)
    {
        $peticionUri = trim($_SERVER['REQUEST_URI'] ?? '', '/');

        $posicionSignoSeparador = strrpos($peticionUri, '?');

        $parametroConsulta = false;

        if ($posicionSignoSeparador !== false) {
            $peticionUri = substr($peticionUri, 0, $posicionSignoSeparador);

            $parametroConsulta = true;
        }

        $ruta = trim($ruta, '/');

        if (strpos($ruta, ':')) {
            $rutaPartes = explode('/', $ruta);
            $rutaPartesTotal = count($rutaPartes);
            $peticionUriPartes = explode('/', $peticionUri);
            $peticionUriPartesTotal = count($peticionUriPartes);

            $parametros = [];

            $coincideRuta = true;
            $parametrosOpcionalesTotal = 0;

            for ($i = 0; $i < $rutaPartesTotal; $i++) {
                if ($rutaPartes[$i] != ($peticionUriPartes[$i] ?? null)
                    && strpos($rutaPartes[$i], ':') === false
                ) {
                    $coincideRuta = false;
                }

                if (strpos($rutaPartes[$i], ':') !== false) {
                    $parametros[] = $peticionUriPartes[$i] ?? null;

                    if (substr($rutaPartes[$i], -1) == '?') {
                        $parametrosOpcionalesTotal++;
                    }
                }
            }

            $coincidenciaRuta = ($coincideRuta && !$parametrosOpcionalesTotal
                && $rutaPartesTotal == $peticionUriPartesTotal)
                || ($coincideRuta && $parametrosOpcionalesTotal
                && $rutaPartesTotal >= $peticionUriPartesTotal
                && ($rutaPartesTotal - $peticionUriPartesTotal)
                <= $parametrosOpcionalesTotal);

            if ($coincidenciaRuta) {
                $respuesta = ['match' => true];

                if ($accion instanceof Closure) {
                    $respuesta['accion'] = Mapeador::mapear(
                        $metodo, $accion,
                        $parametros, $parametroConsulta
                    );

                    return $respuesta;
                } elseif (is_array($accion)) {
                    if (!class_exists($accion[0] ?? '')) {
                        throw new ClaseNoEncontradaExcepcion(
                            'La clase ' . ($accion[0] ?? '') . ' no fue encontrada.'
                        );
                    }

                    $instance = new $accion[0]();

                    if (!method_exists($instance, $accion[1] ?? '')) {
                        throw new MetodoNoEncontradoExcepcion(
                            'El método ' . ($accion[1] ?? '')
                                . ' de la clase ' . ($accion[0] ?? '')
                                . ' no fue encontrado.'
                        );
                    }

                    $respuesta['accion'] = Mapeador::mapear(
                        $metodo, [$instance, $accion[1]],
                        $parametros, $parametroConsulta
                    );

                    return $respuesta;
                }

                throw new AccionNoSoportadaExcepcion(
                    'La acción de la ruta debe estar definida'
                        . ' por una función anónima (closure) o un método de clase.'
                );
            }
        } elseif ($ruta == $peticionUri) {
            $respuesta = ['match' => true];

            if ($accion instanceof Closure) {
                $respuesta['accion'] = Mapeador::mapear(
                    $metodo, $accion, null,
                    $parametroConsulta
                );

                return $respuesta;
            } elseif (is_array($accion)) {
                if (!class_exists($accion[0] ?? '')) {
                    throw new ClaseNoEncontradaExcepcion(
                        'La clase ' . ($accion[0] ?? '') . ' no fue encontrada.'
                    );
                }

                $instance = new $accion[0]();

                if (!method_exists($instance, $accion[1] ?? '')) {
                    throw new MetodoNoEncontradoExcepcion(
                        'El método ' . ($accion[1] ?? '')
                            . ' de la clase ' . ($accion[0] ?? '')
                            . ' no fue encontrado.'
                    );
                }

                $respuesta['accion'] = Mapeador::mapear(
                    $metodo, [$instance, $accion[1]],
                    null, $parametroConsulta
                );

                return $respuesta;
            }

            throw new AccionNoSoportadaExcepcion(
                'La acción de la ruta debe estar definida'
                    . ' por una función anónima (closure) o un método de clase.'
            );
        }

        return [
            'match' => false,
            'accion' => null
        ];
    }
}
