<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 16:43
 */

class ConnectionTest extends PHPUnit\Framework\TestCase
{
    public function testGetClient()
    {
        $connection = new \Habil\Bcoin\Connection('x', 'xxxxxx', '127.0.0.1', '18332');
        $this->assertInstanceOf('GuzzleHttp\Client', $connection->client());
    }
}