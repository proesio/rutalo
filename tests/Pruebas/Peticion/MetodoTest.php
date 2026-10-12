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

namespace Rutalo\Tests\Pruebas\Peticion;

use Rutalo\Ruta;
use Rutalo\Peticion;
use PHPUnit\Framework\TestCase;

class MetodoTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeMetodoGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get?parametro=7';

        $ruta = Ruta::get(
            'get',
            function (Peticion $peticion) {
                return $peticion->metodo();
            }
        );

        $this->assertEquals('GET', $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeMetodoPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post';

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return $peticion->metodo();
            }
        );

        $this->assertEquals('POST', $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeMetodoPut()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/put';

        $_POST['_metodo'] = 'PUT';

        $ruta = Ruta::put(
            'put',
            function (Peticion $peticion) {
                return $peticion->metodo();
            }
        );

        $this->assertEquals('PUT', $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeMetodoPatch()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch',
            function (Peticion $peticion) {
                return $peticion->metodo();
            }
        );

        $this->assertEquals('PATCH', $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeMetodoDelete()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/delete?parametro=7';

        $_POST['_metodo'] = 'DELETE';

        $ruta = Ruta::delete(
            'delete',
            function (Peticion $peticion) {
                return $peticion->metodo();
            }
        );

        $this->assertEquals('DELETE', $ruta->retorno());
    }
}
