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

namespace Rutalo\Tests\Pruebas\Ruta;

use Rutalo\Ruta;
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

        $_SERVER['REQUEST_URI'] = '/get';

        $ruta = Ruta::get(
            'get',
            function () {
                return true;
            }
        );

        $this->assertEquals('GET', $ruta->metodo());
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
            function () {
                return true;
            }
        );

        $this->assertEquals('POST', $ruta->metodo());
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
            function () {
                return true;
            }
        );

        $this->assertEquals('PUT', $ruta->metodo());
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
            function () {
                return true;
            }
        );

        $this->assertEquals('PATCH', $ruta->metodo());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeMetodoDelete()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/delete';

        $_POST['_metodo'] = 'DELETE';

        $ruta = Ruta::delete(
            'delete',
            function () {
                return true;
            }
        );

        $this->assertEquals('DELETE', $ruta->metodo());
    }
}
