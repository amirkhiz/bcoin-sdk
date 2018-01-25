<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 15:56
 */

use Mockery as Mock;
use Habil\Bcoin\Normalizer;
use Habil\Bcoin\Model;
use Habil\Bcoin\Connection;

class NormalizerTest extends PHPUnit\Framework\TestCase
{
    /** @var  \Habil\Bcoin\Connection */
    private $connection;

    /** @var  \Habil\Bcoin\Model */
    private $model;

    /** @var Normalizer */
    private $normalizer;

    public function setUp()
    {
        $this->connection = Mock::mock('Habil\Bcoin\Connection');
        $this->model      = new NormalizeModelStub($this->connection);
        $this->normalizer = new Normalizer($this->model);
    }

    /** @test */
    public function should_require_model()
    {
        $this->expectException('TypeError');

        $normalizer = new Normalizer('', []);
    }

    /** @test */
    public function should_require_options_array()
    {
        $this->expectException('TypeError');

        $normalizer = new Normalizer($this->model, '');
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function model_method_should_require_attributes_array()
    {
        $this->expectException('ArgumentCountError');

        $this->normalizer->model();
    }

    /** @test */
    public function collection_should_require_attributes_array()
    {
        $this->expectException('ArgumentCountError');

        $this->normalizer->collection();
    }
}

class NormalizeModelStub extends Model
{

    public function __construct(Connection $connection, $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);
    }
}