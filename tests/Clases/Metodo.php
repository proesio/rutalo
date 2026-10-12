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

namespace Rutalo\Tests\Clases;

use Rutalo\Peticion;

class Metodo
{
    /**
     * Procesa rutas simples.
     * 
     * @return bool
     */
    public function metodo()
    {
        return true;
    }

    /**
     * Procesa rutas con parámetro.
     * 
     * @param mixed $parametro parametro
     * 
     * @return mixed
     */
    public function metodoParametro($parametro)
    {
        return $parametro;
    }

    /**
     * Procesa rutas con parámetro de consulta.
     * 
     * @param \Rutalo\Peticion $peticion peticion
     * 
     * @return array
     */
    public function metodoParametroConsulta(Peticion $peticion)
    {
        return $peticion->todo();
    }

    /**
     * Procesa rutas con parámetro de consulta y parámetro.
     * 
     * @param \Rutalo\Peticion $peticion  peticion
     * @param mixed            $parametro parametro
     * 
     * @return array
     */
    public function metodoParametroConsultaYParametro(Peticion $peticion, $parametro)
    {
        return [
            'datos' => $peticion->todo(),
            'parametro' => $parametro
        ];
    }
}
