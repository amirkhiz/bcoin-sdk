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

    /**
     * @test
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
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

    /**
     * @test
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function should_serialize_model()
    {
        $wallet          = new Wallet(
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
        $wallet->state   = [
            'tx'          => 0,
            'coin'        => 0,
            'unconfirmed' => 0,
            'confirmed'   => 0,
        ];
        $wallet->master  = ['encrypted' => FALSE];
        $wallet->account = [
            'name'           => "default",
            'initialized'    => TRUE,
            'witness'        => FALSE,
            'watchOnly'      => FALSE,
            'type'           => "pubkeyhash",
            'm'              => 1,
            'n'              => 1,
            'accountIndex'   => 0,
            'receiveDepth'   => 1,
            'changeDepth'    => 1,
            'nestedDepth'    => 0,
            'lookahead'      => 10,
            'receiveAddress' => "mwfDKs919Br8tNFamk6RhRpfaa6cYQ5fMN",
            'nestedAddress'  => NULL,
            'changeAddress'  => "msG6V75J6XNt5mCqBhjgC4MjDH8ivEEMs9",
            'accountKey'     => "tpubDDRH1rj7ut9ZjcGakR9VGgXU8zYSZypLtMr7Aq6CZaBVBrCaMEHPzye6ZZbUpS8YmroLfVp2pPmCdaKtRdCuTCK2HXzwqWX3bMRj3viPMZo",
            'keys'           => [],
        ];

        $stub = json_decode(file_get_contents(dirname(__FILE__) . '/stubs/wallet.json'), TRUE);

        $this->assertEquals(json_encode($stub), $wallet->toJson());
    }
}