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

class TodoTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeTodosLosDatos()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post?parametro=7';

        $_GET['parametro'] = 7;

        $_POST['campo'] = 8;

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return $peticion->todo();
            }
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->campo);
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeDatosComoPropiedadesDeLaInstanciaPeticion()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post?parametro=7';

        $_GET['parametro'] = 7;

        $_POST['campo'] = 8;

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return [
                    'parametro' => $peticion->parametro,
                    'campo' => $peticion->campo
                ];
            }
        );

        $retorno = json_decode($ruta->retorno());

        $this->assertEquals(7, $retorno->parametro);
        $this->assertEquals(8, $retorno->campo);
    }
}
