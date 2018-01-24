<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 11:05
 */

use Mockery as Mock;
use Habil\Bcoin\Persistence\Options;
use \Habil\Bcoin\Models\Wallet;

class PersistableOptionsTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Habil\Bcoin\Querying\Options */
    private $options;

    public function setUp()
    {
        $this->options = new Options(new Wallet(Mock::mock('Habil\Bcoin\Connection'), ['id' => 'newTestWallet']));
    }

    /** @test */
    public function should_generate_create_endpoint()
    {
        $this->assertEquals('wallets', $this->options->create());
    }

    /** @test */
    public function should_generate_update_endpoint()
    {
        $this->assertEquals('wallet/newTestWallet', $this->options->update());
    }

    /** @test */
    public function should_generate_delete_endpoint()
    {
        $this->assertEquals('wallet/newTestWallet', $this->options->delete());
    }
}