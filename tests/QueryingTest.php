<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 10:32
 */

use Mockery as Mock;

class QueryingTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var \Habil\Bcoin\Model
     */
    protected $model;

    /**
     * @var \Habil\Bcoin\Connection
     */
    protected $connection;

    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $message;

    public function setUp()
    {
        $this->connection = Mock::mock('Habil\Bcoin\Connection');
        $this->message    = Mock::mock('GuzzleHttp\Psr7\Response');
        $this->model      = new ModelStub($this->connection);
    }

    public function testTheSingularQueryableName()
    {
        $this->assertEquals('modelstub', $this->model->queryableOptions()->singular());
    }

    public function testThePluralQueryableName()
    {
        $this->assertEquals('the_plural_name', $this->model->queryableOptions()->plural());
    }

    /*public function testFindOneReturnsOneEntity()
    {
        $stub = file_get_contents(dirname(__FILE__).'/stubs/stub.json');
        $this->message->shouldReceive('json')->andReturn(json_decode($stub, true));
        $this->connection->shouldReceive('get')->andReturn($this->message);

        $response = $this->model->find(1);

        $this->assertTrue(isset($response->stub));
    }

    public function testFindAllReturnsAllEntities()
    {
        $stub = file_get_contents(dirname(__FILE__).'/stubs/stubs.json');
        $this->message->shouldReceive('json')->andReturn(json_decode($stub, true));
        $this->connection->shouldReceive('get')->andReturn($this->message);

        $response = $this->model->all();

        $this->assertTrue(isset($response['stubs']));
    }*/
}