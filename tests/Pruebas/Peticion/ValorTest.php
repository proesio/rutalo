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

class ValorTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeValor()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post';

        $_POST['campo'] = 7;

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return $peticion->valor('campo');
            }
        );

        $this->assertEquals(7, $ruta->retorno());
    }

    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeValorPredeterminado()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post';

        $_POST['campo'] = 7;

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return $peticion->valor('campo_inexistente', 8);
            }
        );

        $this->assertEquals(8, $ruta->retorno());
    }
}
