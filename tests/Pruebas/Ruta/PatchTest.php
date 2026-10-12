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

class PatchTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testSimpleConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['campo'] = 7;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch',
            function (Peticion $peticion) {
                return $peticion->valor('campo');
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
    public function testSimpleConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['campo'] = 7;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch', [Metodo::class, 'metodoParametroConsulta']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro',
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
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroIntermedioConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7/intermedio';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro/intermedio',
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
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroIntermedioConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7/intermedio';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro/intermedio',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
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
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalNuloConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
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
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroOpcionalNuloConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertNull($retorno->parametro);
        $this->assertEquals(8, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch?parametro=7';

        $_GET['parametro'] = 7;

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch',
            function (Peticion $peticion) {
                return $peticion->todo();
            }
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch?parametro=7';

        $_GET['parametro'] = 7;

        $_POST['campo'] = 8;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch',
            [Metodo::class, 'metodoParametroConsulta']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7?parametro=8';

        $_GET['parametro'] = 8;

        $_POST['campo'] = 9;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro',
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
        $this->assertEquals(9, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7?parametro=8';

        $_GET['parametro'] = 8;

        $_POST['campo'] = 9;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
        $this->assertEquals(9, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7?parametro=8';

        $_GET['parametro'] = 8;

        $_POST['campo'] = 9;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
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
        $this->assertEquals(9, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch/7?parametro=8';

        $_GET['parametro'] = 8;

        $_POST['campo'] = 9;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
        $this->assertEquals(9, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalNuloConClosure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch?parametro=8';

        $_GET['parametro'] = 8;

        $_POST['campo'] = 9;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
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
        $this->assertEquals(9, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeParametroDeConsultaYParametroOpcionalNuloConMetodo()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch?parametro=8';

        $_GET['parametro'] = 8;

        $_POST['campo'] = 9;

        $_POST['_metodo'] = 'PATCH';

        $ruta = Ruta::patch(
            'patch/:parametro?',
            [Metodo::class, 'metodoParametroConsultaYParametro']
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertTrue($ruta->coincide());
        $this->assertNull($retorno->parametro);
        $this->assertEquals(8, $retorno->datos->parametro);
        $this->assertEquals(9, $retorno->datos->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionAccionNoSoportada()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['_metodo'] = 'PATCH';

        $this->expectException(AccionNoSoportadaExcepcion::class);

        Ruta::patch('patch', null);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionClaseNoEncontrada()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['_metodo'] = 'PATCH';

        $this->expectException(ClaseNoEncontradaExcepcion::class);

        Ruta::patch('patch', ['Clase\Inexistente']);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionMetodoNoEncontrado()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/patch';

        $_POST['_metodo'] = 'PATCH';

        $this->expectException(MetodoNoEncontradoExcepcion::class);

        Ruta::patch('patch', [Metodo::class, 'metodoInexistente']);
    }
}
