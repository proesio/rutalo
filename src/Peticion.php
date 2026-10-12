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

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Peticion
{
    /**
     * Establece los encabezados de la petición.
     *
     * @var array
     */
    private $_encabezados = [];

    /**
     * Establece los datos de la petición.
     *
     * @var array
     */
    private $_datos = [];

    /**
     * Establece el contenido de la petición.
     *
     * @var string
     */
    private $_contenido = '';

    /**
     * Establece el método de la petición.
     *
     * @var string
     */
    private $_metodo = '';

    /**
     * Establece la ruta de la petición.
     *
     * @var string
     */
    private $_ruta = '';

    /**
     * Crea una nueva instancia de la clase Peticion.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->_encabezados = apache_request_headers() ?? [];

        $this->_datos = array_merge($_POST, $_GET, $_FILES);

        $contenido = file_get_contents('php://input');

        $this->_contenido = $contenido !== false ? $contenido : '';

        $this->_metodo = $_SERVER['REQUEST_METHOD'] ?? null;

        $this->_ruta = $_SERVER['REQUEST_URI'] ?? '';

        if (in_array('_metodo', array_keys($this->_datos))) {
            $this->_metodo = $this->_datos['_metodo'];
        }

        $this->_asignarPropiedades($this->todo());
    }

    // Inicio métodos públicos.

    // Inicio datos de petición.

    /**
     * Obtiene los datos fusionados con el contenido de la petición.
     * 
     * @return array
     */
    public function todo()
    {
        $datos = $this->_datos;

        if (json_validate($this->_contenido)) {
            $contenido = json_decode($this->_contenido, true);

            $datos = array_merge($datos, $contenido);
        }

        return $datos;
    }

    /**
     * Obtiene el contenido de la petición.
     * 
     * @return string
     */
    public function contenido()
    {
        return $this->_contenido;
    }

    /**
     * Obtiene los datos de la petición.
     * 
     * @return array
     */
    public function datos()
    {
        return $this->_datos;
    }

    /**
     * Obtiene un valor por su clave, si no existe, devuelve el valor por defecto.
     * 
     * @param string      $clave          clave
     * @param string|null $predeterminado predeterminado
     * 
     * @return mixed
     */
    public function valor($clave, $predeterminado = null)
    {
        $datos = $this->todo();

        return $datos[$clave] ?? $predeterminado;
    }

    /**
     * Obtiene un valor por su clave.
     * 
     * @param string $clave clave
     * 
     * @return mixed
     */
    public function obtener($clave)
    {
        $datos = $this->todo();

        return $datos[$clave] ?? null;
    }

    /**
     * Obtiene un valor por su clave, exclusivamente de la "query string",
     * si no existe, devuelve el valor por defecto.
     * 
     * @param string      $clave          clave
     * @param string|null $predeterminado predeterminado
     * 
     * @return string|null
     */
    public function consulta($clave, $predeterminado = null)
    {
        return $_GET[$clave] ?? $predeterminado;
    }

    /**
     * Obtiene un valor por su clave, exclusivamente de "$_FILES".
     * 
     * @param string $clave clave
     * 
     * @return array|null
     */
    public function archivo($clave)
    {
        return $_FILES[$clave] ?? null;
    }

    /**
     * Determina si un valor de tipo archivo está presente en la petición.
     * 
     * @param string $clave clave
     * 
     * @return bool
     */
    public function tieneArchivo($clave)
    {
        return ($_FILES[$clave] ?? null) ? true : false;
    }

    /**
     * Obtiene únicamente los datos filtrados de la petición.
     * 
     * @param array $claves claves
     * 
     * @return array
     */
    public function unicamente($claves)
    {
        $datos = $this->todo();

        return array_intersect_key($datos, array_flip($claves));
    }

    /**
     * Obtiene los datos excepto los filtrados de la petición.
     * 
     * @param array $claves claves
     * 
     * @return array
     */
    public function excepto($claves)
    {
        $datos = $this->todo();

        return array_diff_key($datos, array_flip($claves));
    }

    /**
     * Determina si un valor está presente en la petición.
     * 
     * @param array $clave clave
     * 
     * @return bool
     */
    public function tiene($clave)
    {
        $datos = $this->todo();

        return array_key_exists($clave, $datos);
    }

    /**
     * Determina si un valor no está presente en la petición.
     * 
     * @param array $clave clave
     * 
     * @return bool
     */
    public function noTiene($clave)
    {
        $datos = $this->todo();

        return !array_key_exists($clave, $datos);
    }

    /**
     * Determina si un valor está presente en la petición y no está vacío.
     * 
     * @param array $clave clave
     * 
     * @return bool
     */
    public function completo($clave)
    {
        $datos = $this->todo();

        return !empty($datos[$clave] ?? null);
    }

    // Fin datos de petición.

    // Inicio encabezados de petición.

    /**
     * Obtiene los encabezados de la petición.
     * 
     * @return array
     */
    public function encabezados()
    {
        return $this->_encabezados;
    }

    /**
     * Obtiene un valor del encabezado por su clave.
     * 
     * @param string $clave clave
     * 
     * @return string|null
     */
    public function encabezado($clave)
    {
        $clave = strtolower($clave);

        $encabezados = array_change_key_case($this->_encabezados, CASE_LOWER);

        return $encabezados[$clave] ?? null;
    }

    /**
     * Determina si un valor de encabezado está presente en la petición.
     * 
     * @param string $clave clave
     * 
     * @return bool
     */
    public function tieneEncabezado($clave)
    {
        return $this->encabezado($clave) ? true : false;
    }

    // Fin encabezados de petición.

    // Inicio rutas, URLs y métodos HTTP.

    /**
     * Obtiene la ruta de la petición.
     * 
     * @return string
     */
    public function ruta()
    {
        return parse_url($this->_ruta, PHP_URL_PATH);
    }

    /**
     * Obtiene la url de la petición sin la "query string".
     * 
     * @return string
     */
    public function url()
    {
        $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
            ? 'https://' : 'http://';

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        return $protocolo . $host . $this->ruta();
    }

    /**
     * Obtiene la url completa de la petición.
     * 
     * @return string
     */
    public function urlCompleta()
    {
        $consulta = parse_url($this->_ruta, PHP_URL_QUERY);

        $signo = $consulta ? '?' : '';

        return $this->url() . $signo . $consulta;
    }

    /**
     * Añade o modifica parámetros de la URL actual de la petición.
     * 
     * @param array $parametros parametros
     * 
     * @return string
     */
    public function urlCompletaConsulta($parametros = [])
    {
        $consulta = [];

        $urlConsulta = parse_url($this->_ruta, PHP_URL_QUERY) ?? '';

        parse_str($urlConsulta, $consulta);

        $urlConsulta = http_build_query(array_merge($consulta, $parametros));

        $signo = $urlConsulta ? '?' : '';

        return $this->url() . $signo . $urlConsulta;
    }

    /**
     * Obtiene el método de la petición.
     * 
     * @return string
     */
    public function metodo()
    {
        return $this->_metodo;
    }

    /**
     * Determina si el método de la petición coincide con la cadena dada.
     * 
     * @param string $metodo metodo
     * 
     * @return bool
     */
    public function esMetodo($metodo)
    {
        $metodo = strtolower($metodo);

        $actualMetodo = strtolower($this->metodo());

        return $metodo == $actualMetodo ? true : false;
    }

    // Fin rutas, URLs y métodos HTTP.

    // Inicio información del cliente.

    /**
     * Obtiene la IP de origen de la petición.
     * 
     * @return string
     */
    public function ip()
    {
        $ip = '0.0.0.0';

        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ips[0]);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        return $ip;
    }

    /**
     * Obtiene un arreglo de direcciones IP de origen de la petición.
     * 
     * @return array
     */
    public function ips()
    {
        $ips = [];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipPartes = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ips = array_map('trim', $ipPartes);
        }

        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            if (!in_array($_SERVER['HTTP_CF_CONNECTING_IP'], $ips)) {
                array_unshift($ips, $_SERVER['HTTP_CF_CONNECTING_IP']);
            }
        }

        if (!empty($_SERVER['REMOTE_ADDR'])) {
            if (!in_array($_SERVER['REMOTE_ADDR'], $ips)) {
                $ips[] = $_SERVER['REMOTE_ADDR'];
            }
        }

        $ipsVerificadas = array_filter(
            $ips, function ($ip) {
                return filter_var($ip, FILTER_VALIDATE_IP);
            }
        );

        $ipsVerificadas = array_values($ipsVerificadas);

        return $ipsVerificadas;
    }

    /**
     * Obtiene el user agent de la petición.
     * 
     * @return string|null
     */
    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    // Fin información del cliente.

    // Fin métodos públicos.

    // Inicio métodos privados.

    /**
     * Asigna dinámicamente los datos de la petición.
     * 
     * @param array $datos datos
     * 
     * @return void
     */
    private function _asignarPropiedades($datos)
    {
        foreach ($datos as $clave => $valor) {
            $this->{$clave} = $valor; 
        }
    }

    // Fin métodos privados.
}
