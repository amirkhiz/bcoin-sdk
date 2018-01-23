<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 13:39
 */

use Mockery as Mock;

class SerializableTest extends PHPUnit\Framework\TestCase
{
    /** @var \Habil\Bcoin\Connection */
    private $connection;

    /** @var \Habil\Bcoin\Model */
    private $model;

    public function setUp()
    {
        $this->connection = Mock::mock('\Habil\Bcoin\Connection');
        $this->model = new SerializableModelStub($this->connection);
    }

    /** @test */
    public function should_get_serializable_options()
    {
        $options = $this->model->serializableOptions();

        $this->assertTrue(is_array($options));
        $this->assertTrue(is_array($options['root']));
        $this->assertEquals('serializablemodelstubs', $options['collection_root']);
    }
}

class SerializableModelStub extends \Habil\Bcoin\Model {

    use \Habil\Bcoin\Serializable;

    protected $serializableConfig = ['root' => ['person', 'organisation']];

    public function __construct(\Habil\Bcoin\Connection $connection, $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);
    }

}