<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 17:26
 */

use Mockery as Mock;
use Habil\Bcoin\Models\Wallet;

class WalletTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Habil\Bcoin\Connection */
    private $connection;

    /** @var \Habil\Bcoin\Models\Wallet */
    private $wallet;

    /** @var \GuzzleHttp\Psr7\Response */
    private $message;

    public function setUp()
    {
        $this->connection = Mock::mock('Habil\Bcoin\Connection');
        $this->wallet     = new Wallet($this->connection);
        $this->message    = Mock::mock('Psr\Http\Message\ResponseInterface');
    }

    /** @test */
    public function find_wallet_by_id()
    {
        $response = file_get_contents(dirname(__FILE__) . '/stubs/wallet.json');
        $this->message->shouldReceive('json')->andReturn(json_decode($response, TRUE));
        $this->connection->shouldReceive('get')->andReturn($this->message);

        $wallet = $this->wallet->find('primary');

        $this->assertInstanceOf('Habil\Bcoin\Models\Wallet', $wallet);
        $this->assertEquals('primary', $wallet->id);
        $this->assertEquals(1, $wallet->wid);
        $this->assertEquals(TRUE, $wallet->initialized);
        $this->assertEquals(FALSE, $wallet->watch_only);
        $this->assertEquals(1, $wallet->account_depth);
        $this->assertEquals('977fbb8d212a1e78c7ce9dfda4ff3d7cc8bcd20c4ccf85d2c9c84bbef6c88b3c', $wallet->token);
    }

    /** @test */
    public function find_all_wallets()
    {
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function should_serialize_model()
    {
        $wallet = new Wallet(
            $this->connection,
            [
                'network'       => 'testnet',
                'wid'           => 1,
                'id'            => 'primary',
                'initialized'   => TRUE,
                'watch_only'    => FALSE,
                'account_depth' => 1,
                'token'         => '977fbb8d212a1e78c7ce9dfda4ff3d7cc8bcd20c4ccf85d2c9c84bbef6c88b3c',
                'token_depth'   => 0,
            ]
        );

        $stub = json_decode(file_get_contents(dirname(__FILE__) . '/stubs/wallet.json'), TRUE);
//        unset($stub['wallet']['state'], $stub['wallet']['master'], $stub['wallet']['account']);

        $this->assertEquals(json_encode($stub), $wallet->toJson());
    }
}