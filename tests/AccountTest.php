<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 16:24
 */

use Habil\Bcoin\Models\Account;

class AccountTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Habil\Bcoin\Models\Account */
    private $account;

    public function setUp()
    {
        $this->account = new Account(
            [
                'name'            => 'default',
                'initialized'     => TRUE,
                'witness'         => FALSE,
                'watch_only'      => FALSE,
                'type'            => 'pubkeyhash',
                'm'               => 1,
                'n'               => 1,
                'account_index'   => 0,
                'receive_depth'   => 1,
                'change_depth'    => 1,
                'nested_depth'    => 0,
                'lookahead'       => 10,
                'receive_address' => 'mwfDKs919Br8tNFamk6RhRpfaa6cYQ5fMN',
                'nested_address'  => NULL,
                'change_address'  => 'msG6V75J6XNt5mCqBhjgC4MjDH8ivEEMs9',
                'account_key'     => 'tpubDDRH1rj7ut9ZjcGakR9VGgXU8zYSZypLtMr7Aq6CZaBVBrCaMEHPzye6ZZbUpS8YmroLfVp2pPmCdaKtRdCuTCK2HXzwqWX3bMRj3viPMZo',
            ]
        );
    }

    /** @test */
    public function should_create_new_address()
    {
        $this->assertEquals('default', $this->account->name);
        $this->assertEquals(TRUE, $this->account->initialized);
        $this->assertEquals(FALSE, $this->account->witness);
        $this->assertEquals(FALSE, $this->account->watch_only);
        $this->assertEquals('pubkeyhash', $this->account->type);
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function should_serialize()
    {
        $this->assertTrue(is_object(json_decode($this->account->toJson())));
    }
}