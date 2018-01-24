<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 18:04
 */

use Mockery as Mock;

class BcoinTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var \Habil\Bcoin\Bcoin
     */
    protected $bcoin;

    public function setUp()
    {
        $connection = Mock::mock('Habil\Bcoin\Connection');

        $this->bcoin = new Habil\Bcoin\Bcoin($connection);
    }

    /**
     * @expectedException TypeError
     */
    public function testBcoinRequiresConnection()
    {
        $this->expectException('TypeError');

        $bcoin = new Habil\Bcoin\Bcoin('');
    }

    public function testCreateNewWalletModel()
    {
        $this->assertInstanceOf('Habil\Bcoin\Models\Wallet', $this->bcoin->wallet());
    }
}