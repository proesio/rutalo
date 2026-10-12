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

class EncabezadosTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeEncabezados()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post';

        $_SERVER['HTTP_ENCABEZADO'] = 'VALOR';

        $_SERVER['HTTP_ENCABEZADO_1'] = 'VALOR1';

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return $peticion->encabezados();
            }
        );

        $retorno = json_decode($ruta->retorno(), true);

        $this->assertCount(2, $retorno);
        $this->assertEquals('VALOR', $retorno['Encabezado']);
        $this->assertEquals('VALOR1', $retorno['Encabezado-1']);
    }
}
