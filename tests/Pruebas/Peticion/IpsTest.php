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

class IpsTest extends TestCase
{
    /**
     * Ejecuta la prueba.
     * 
     * @return void
     */
    public function testDeObtencionDeIps()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_SERVER['REQUEST_URI'] = '/post';

        $_SERVER['HTTP_CF_CONNECTING_IP'] = '0.0.0.0';

        $_SERVER['HTTP_X_FORWARDED_FOR'] = '0.0.0.1,0.0.0.2';

        $_SERVER['REMOTE_ADDR'] = '0.0.0.4';

        $ruta = Ruta::post(
            'post',
            function (Peticion $peticion) {
                return $peticion->ips();
            }
        );

        $retorno = json_decode($ruta->retorno(), true);

        $this->assertCount(4, $retorno);
        $this->assertContains('0.0.0.0', $retorno);
        $this->assertContains('0.0.0.1', $retorno);
        $this->assertContains('0.0.0.2', $retorno);
        $this->assertContains('0.0.0.4', $retorno);
    }
}
