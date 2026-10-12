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
use Rutalo\Peticion;
use PHPUnit\Framework\TestCase;
use Rutalo\Tests\Clases\Metodo;
use Rutalo\Excepciones\AccionNoSoportadaExcepcion;
use Rutalo\Excepciones\ClaseNoEncontradaExcepcion;
use Rutalo\Excepciones\MetodoNoEncontradoExcepcion;

class GetTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testSimpleConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $ruta = Ruta::get(
            'get',
            function () {
                return true;
            }
        );

        $this->assertTrue($ruta->coincide());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testSimpleConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $ruta = Ruta::get('get', [Metodo::class, 'metodo']);

        $this->assertTrue($ruta->coincide());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7';

        $ruta = Ruta::get(
            'get/:parametro',
            function ($parametro) {
                return $parametro;
            }
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7';

        $ruta = Ruta::get(
            'get/:parametro',
            [Metodo::class, 'metodoParametro']
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroIntermedioConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7/intermedio';

        $ruta = Ruta::get(
            'get/:parametro/intermedio',
            function ($parametro) {
                return $parametro;
            }
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroIntermedioConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7/intermedio';

        $ruta = Ruta::get(
            'get/:parametro/intermedio',
            [Metodo::class, 'metodoParametro']
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7';

        $ruta = Ruta::get(
            'get/:parametro?',
            function ($parametro) {
                return $parametro;
            }
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7';

        $ruta = Ruta::get(
            'get/:parametro?',
            [Metodo::class, 'metodoParametro']
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalNuloConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $ruta = Ruta::get(
            'get/:parametro?',
            function ($parametro) {
                return $parametro;
            }
        );

        $this->assertTrue($ruta->coincide());
        $this->assertNull($ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalNuloConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $ruta = Ruta::get(
            'get/:parametro?',
            [Metodo::class, 'metodoParametro']
        );

        $this->assertTrue($ruta->coincide());
        $this->assertNull($ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get?parametro=7';

        $_GET['parametro'] = 7;

        $ruta = Ruta::get(
            'get',
            function (Peticion $peticion) {
                return $peticion->consulta('parametro');
            }
        );

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get?parametro=7';

        $_GET['parametro'] = 7;

        $ruta = Ruta::get(
            'get',
            [Metodo::class, 'metodoParametroConsulta']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7?parametro=8';

        $_GET['parametro'] = 8;

        $ruta = Ruta::get(
            'get/:parametro',
            function (Peticion $peticion, $parametro) {
                return [
                    'datos' => $peticion->todo(),
                    'parametro' => $parametro
                ];
            }
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7?parametro=8';

        $_GET['parametro'] = 8;

        $ruta = Ruta::get(
            'get/:parametro',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7?parametro=8';

        $_GET['parametro'] = 8;

        $ruta = Ruta::get(
            'get/:parametro?',
            function (Peticion $peticion, $parametro) {
                return [
                    'datos' => $peticion->todo(),
                    'parametro' => $parametro
                ];
            }
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get/7?parametro=8';

        $_GET['parametro'] = 8;

        $ruta = Ruta::get(
            'get/:parametro?',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalNuloConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get?parametro=8';

        $_GET['parametro'] = 8;

        $ruta = Ruta::get(
            'get/:parametro?',
            function (Peticion $peticion, $parametro) {
                return [
                    'datos' => $peticion->todo(),
                    'parametro' => $parametro
                ];
            }
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertNull($retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalNuloConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get?parametro=8';

        $_GET['parametro'] = 8;

        $ruta = Ruta::get(
            'get/:parametro?',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertNull($retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionAccionNoSoportada()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $this->expectException(AccionNoSoportadaExcepcion::class);

        Ruta::get('get', null);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionClaseNoEncontrada()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $this->expectException(ClaseNoEncontradaExcepcion::class);

        Ruta::get('get', ['Clase\Inexistente']);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionMetodoNoEncontrado()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $this->expectException(MetodoNoEncontradoExcepcion::class);

        Ruta::get('get', [Metodo::class, 'metodoInexistente']);
    }
}
