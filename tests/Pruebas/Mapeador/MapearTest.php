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

namespace Rutalo\Tests\Pruebas\Mapeador;

use Rutalo\Mapeador;
use PHPUnit\Framework\TestCase;
use Rutalo\Excepciones\MetodoHttpNoSoportadoExcepcion;

class MapearTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeExcepcionMetodoHttpNoSoportado()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/get';

        $this->expectException(MetodoHttpNoSoportadoExcepcion::class);

        Mapeador::mapear('METODO_HTTP_INEXISTENTE', null, [], false);
    }
}
