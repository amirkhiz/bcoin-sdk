<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 26.01.2018
 * Time: 17:02
 */

use Mockery as Mock;
use \Habil\Bcoin\Models\Transaction;

class TransactionTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Habil\Bcoin\Connection */
    private $connection;

    /** @var \Habil\Bcoin\Models\Transaction */
    private $transaction;

    /** @var \GuzzleHttp\Psr7\Response */
    private $message;

    public function setUp()
    {
        $this->connection  = Mock::mock('Habil\Bcoin\Connection');
        $this->transaction = new Transaction($this->connection);
        $this->message     = Mock::mock('Psr\Http\Message\ResponseInterface');
    }

    /**
     * @test
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function find_transactions_by_address()
    {
        $response = file_get_contents(dirname(__FILE__) . '/stubs/transactions.json');
        $this->message->shouldReceive('getBody')->andReturn($response);
        $this->connection->shouldReceive('get')->andReturn($this->message);

        $transactions = $this->transaction->findByAddress('mmcF7JYSppdnxDRqMi1H5GPyJRHNXdQjdD');

        $transaction = $transactions[0];
        $this->assertInstanceOf('Habil\Bcoin\Models\Transaction', $transaction);
        $this->assertEquals('8351d991c5dfb49d534fcd28f56bb2d5b0d5f31f5c9e2e0711b5f86312a5abfe', $transaction->hash);
        $this->assertEquals(
            '8351d991c5dfb49d534fcd28f56bb2d5b0d5f31f5c9e2e0711b5f86312a5abfe',
            $transaction->witness_hash
        );
        $this->assertEquals(50000, $transaction->fee);
        $this->assertEquals(129198, $transaction->rate);
        $this->assertEquals(1501093478, $transaction->mtime);
        $this->assertEquals(467, $transaction->height);
    }
}