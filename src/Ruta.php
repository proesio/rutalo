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

use Rutalo\Enrutador;

class Ruta
{
    /**
     * Autor de la librería Rutalo.
     *
     * @var string
     */
    public const AUTOR = 'Juan Felipe Valencia Murillo';

    /**
     * Versión actual la librería Rutalo.
     *
     * @var string
     */
    public const VERSION = '1.0.0';

    /**
     * Establece si existe coincidencia en una ruta.
     *
     * @var bool
     */
    private static $_coincidenciaRuta = false;

    /**
     * Establece las propiedades de la ruta.
     *
     * @var array
     */
    private $_propiedades = [];

    /**
     * Crea una nueva instancia de la clase Ruta.
     *
     * @param array $propiedades propiedades
     * 
     * @return void
     */
    public function __construct($propiedades = [])
    {
        $this->_propiedades = [
            'metodo' => $propiedades['metodo'] ?? null,
            'ruta' => $propiedades['ruta'] ?? null,
            'accion' => $propiedades['accion'] ?? null,
            'retorno' => $propiedades['retorno'] ?? null,
            'coincide' => $propiedades['coincide'] ?? false
        ];
    }

    // Inicio métodos públicos.

    /**
     * Procesa rutas utilizando el método HTTP GET.
     * 
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return self
     */
    public static function get($ruta, $accion)
    {
        $metodo = strtoupper($_SERVER['REQUEST_METHOD']);

        if (isset($_SERVER['REQUEST_METHOD'])
            && $metodo == 'GET'
            && !self::$_coincidenciaRuta
        ) {
            return self::_procesarCoincidenciaRuta($metodo, $ruta, $accion);
        }

        return new self(
            [
                'metodo' => $metodo,
                'ruta' => $ruta,
                'accion' => $accion,
                'retorno' => null,
                'coincide' => false
            ]
        );
    }

    /**
     * Procesa rutas utilizando el método HTTP POST.
     * 
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return self
     */
    public static function post($ruta, $accion)
    {
        $metodo = strtoupper($_SERVER['REQUEST_METHOD']);

        if (isset($_SERVER['REQUEST_METHOD'])
            && $metodo == 'POST'
            && !self::$_coincidenciaRuta
        ) {
            return self::_procesarCoincidenciaRuta($metodo, $ruta, $accion);
        }

        return new self(
            [
                'metodo' => $metodo,
                'ruta' => $ruta,
                'accion' => $accion,
                'retorno' => null,
                'coincide' => false
            ]
        );
    }

    /**
     * Procesa rutas utilizando el método HTTP PUT.
     * 
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return self
     */
    public static function put($ruta, $accion)
    {
        $metodo = strtoupper($_SERVER['REQUEST_METHOD']);

        if (isset($_POST['_metodo'])) {
            $metodo = strtoupper($_POST['_metodo']);
        }

        if (isset($_SERVER['REQUEST_METHOD'])
            && $metodo == 'PUT'
            && !self::$_coincidenciaRuta
        ) {
            return self::_procesarCoincidenciaRuta($metodo, $ruta, $accion);
        }

        return new self(
            [
                'metodo' => $metodo,
                'ruta' => $ruta,
                'accion' => $accion,
                'retorno' => null,
                'coincide' => false
            ]
        );
    }

    /**
     * Procesa rutas utilizando el método HTTP PATCH.
     * 
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return self
     */
    public static function patch($ruta, $accion)
    {
        $metodo = strtoupper($_SERVER['REQUEST_METHOD']);

        if (isset($_POST['_metodo'])) {
            $metodo = strtoupper($_POST['_metodo']);
        }

        if (isset($_SERVER['REQUEST_METHOD'])
            && $metodo == 'PATCH'
            && !self::$_coincidenciaRuta
        ) {
            return self::_procesarCoincidenciaRuta($metodo, $ruta, $accion);
        }

        return new self(
            [
                'metodo' => $metodo,
                'ruta' => $ruta,
                'accion' => $accion,
                'retorno' => null,
                'coincide' => false
            ]
        );
    }

    /**
     * Procesa rutas utilizando el método HTTP DELETE.
     * 
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return self
     */
    public static function delete($ruta, $accion)
    {
        $metodo = strtoupper($_SERVER['REQUEST_METHOD']);

        if (isset($_POST['_metodo'])) {
            $metodo = strtoupper($_POST['_metodo']);
        }

        if (isset($_SERVER['REQUEST_METHOD'])
            && $metodo == 'DELETE'
            && !self::$_coincidenciaRuta
        ) {
            return self::_procesarCoincidenciaRuta($metodo, $ruta, $accion);
        }

        return new self(
            [
                'metodo' => $metodo,
                'ruta' => $ruta,
                'accion' => $accion,
                'retorno' => null,
                'coincide' => false
            ]
        );
    }

    /**
     * Obtiene el método HTTP de la ruta.
     * 
     * @return string|null
     */
    public function metodo()
    {
        return $this->_propiedades['metodo'];
    }

    /**
     * Obtiene el nombre de la ruta.
     * 
     * @return string|null
     */
    public function ruta()
    {
        return $this->_propiedades['ruta'];
    }

    /**
     * Obtiene la acción de la ruta.
     * 
     * @return mixed
     */
    public function accion()
    {
        return $this->_propiedades['accion'];
    }

    /**
     * Obtiene el resultado de la acción de la ruta.
     * 
     * @return string|null
     */
    public function retorno()
    {
        return $this->_propiedades['retorno'];
    }

    /**
     * Determina si existe coincidencia con la ruta actual.
     * 
     * @return bool
     */
    public function coincide()
    {
        return $this->_propiedades['coincide'];
    }

    // Fin métodos públicos.

    // Inicio métodos privados.

    /**
     * Procesa la coincidencia de ruta.
     * 
     * @param string $metodo metodo
     * @param string $ruta   ruta
     * @param mixed  $accion accion
     * 
     * @return self
     */
    private static function _procesarCoincidenciaRuta($metodo, $ruta, $accion)
    {
        $respuesta = Enrutador::enrutar(
            $metodo, $ruta, $accion
        );

        $retorno = null;

        $coincide = false;

        if ($respuesta['match']) {
            $tipoVariable = strtolower(
                gettype($respuesta['accion'])
            );

            $esJsonSerializable = in_array($tipoVariable, ['array', 'object']);

            $esEncadenable = in_array(
                $tipoVariable, ['boolean', 'integer', 'double', 'string']
            );

            if ($esJsonSerializable) {
                $retorno = json_encode($respuesta['accion']);
            } elseif ($esEncadenable) {
                $retorno = $respuesta['accion'];
            }

            echo $retorno;

            self::$_coincidenciaRuta = true;

            $coincide = true;
        }

        return new self(
            [
                'metodo' => $metodo,
                'ruta' => $ruta,
                'accion' => $accion,
                'retorno' => $retorno,
                'coincide' => $coincide
            ]
        );
    }

    // Fin métodos privados.
}
