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

class RetornoTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeRetorno()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $ruta = Ruta::get(
            'get',
            function () {
                return 7 * 8;
            }
        );

        $this->assertEquals(56, $ruta->retorno());
    }
}
