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

        $input = $transaction->inputs[0];
        $this->assertInstanceOf('Habil\Bcoin\Models\Input', $input);
        $this->assertEquals(
            '47304402201c29f13e8d817f2c2d1ea8b89d1d603677b86d0b4658f5d836bb16c56dc5dc3e02203e815b7ef739ba95c7bbbfdd63f38baa0806ad235f73c7df2492271e0b14ea43012103d50917ce22f377797a28c5e17e33000ea7d7d149d98b942d83f25ef2a223a8aa',
            $input->script
        );
        $this->assertEquals('00', $input->witness);
        $this->assertEquals(4294967295, $input->sequence);

        $output = $transaction->outputs[0];
        $this->assertInstanceOf('Habil\Bcoin\Models\Output', $output);
        $this->assertEquals(1021229, $output->value);
        $this->assertEquals('76a91419eb536dc042d76454bea8dbec5ddc384e783e5a88ac', $output->script);
        $this->assertEquals('mht16aZhnsHivv3cDGuzgHGvoLFy8rNkg8', $output->address);
    }

    /**
     * @test
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function find_transaction_by_hash()
    {
        $response = file_get_contents(dirname(__FILE__) . '/stubs/transaction.json');
        $this->message->shouldReceive('getBody')->andReturn($response);
        $this->connection->shouldReceive('get')->andReturn($this->message);

        $transaction = $this->transaction->findByHash(
            '95a140f51e1c393074f210b9641b2e39',
            '1098baa24696347f0a1eaac8d4422d4b0f9809e48af54af074d5787dfcb72b34'
        );

        $this->assertInstanceOf('Habil\Bcoin\Models\Transaction', $transaction);
        $this->assertEquals(6, $transaction->wid);
        $this->assertEquals('95a140f51e1c393074f210b9641b2e39', $transaction->id);
        $this->assertEquals(
            '1098baa24696347f0a1eaac8d4422d4b0f9809e48af54af074d5787dfcb72b34',
            $transaction->hash
        );
        $this->assertEquals(0, $transaction->fee);
        $this->assertEquals(0, $transaction->rate);
        $this->assertEquals(1517214836, $transaction->mtime);
        $this->assertEquals(1517215480, $transaction->time);
        $this->assertEquals('2018-01-29T08:44:40Z', $transaction->date);
        $this->assertEquals(1261021, $transaction->height);
        $this->assertEquals('000000007fa1d0bc4418a06bb6006bd5ad8d7683ebd46fc39207002ee0bd725b', $transaction->block);
        $this->assertEquals(250, $transaction->size);
        $this->assertEquals(168, $transaction->virtual_size);
        $this->assertEquals(612, $transaction->confirmations);
        $this->assertEquals(
            '010000000001015e4cfc2c7c9f06cd86788760fbeea5eca4516c986ab25d1081332f5313049afa0100000017160014f7f18670ef96e95f93d75630a9474f4ebf136220ffffffff0240d2df03000000001976a91442d0dee419f56faf5bac27493e0c72c07769f4b688acde504f281000000017a9141c496bd46d57597c2d6261a6c30ea332b962f93e8702483045022100d6ce877df40deeed699dcf24de7d438798b04bab9a2ed2271c5c43318631f35802204f579a280ff534bdab0545aa88551a2e26d5b55392032b7b5a2a549e498353170121034ed3747cca8aa2a482cd5f9287079e8111c058c9b5eaea2e946d8e71519de5ca00000000',
            $transaction->tx
        );

        $input = $transaction->inputs[0];
        $this->assertInstanceOf('Habil\Bcoin\Models\Input', $input);
        $this->assertEquals(0, $input->value);
        $this->assertEquals('tb1q7lccvu80jm54ly7h2cc2j360f6l3xc3qfx8jyf', $input->address);
        $this->assertEquals(NULL, $input->path);

        $output = $transaction->outputs[0];
        $this->assertInstanceOf('Habil\Bcoin\Models\Output', $output);
        $this->assertEquals(65000000, $output->value);
        $this->assertEquals('mmcF7JYSppdnxDRqMi1H5GPyJRHNXdQjdD', $output->address);
    }
}