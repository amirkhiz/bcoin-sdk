<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 16:40
 */

use Habil\Bcoin\Connection;

class ModelTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var \Habil\Bcoin\Model
     */
    protected $model;

    public function setUp()
    {
        $this->model = new ModelStub(new Connection('', '', '', ''), ['name' => 'Siavash Habil']);
    }

    public function testConnectionMethodHasConnection()
    {
        $this->assertInstanceOf('Habil\Bcoin\Connection', $this->model->connection());
    }

    public function testSettingAnArrayOfAttributes()
    {
        $this->assertEquals('Siavash Habil', $this->model->name);
    }

    public function testSettingAProperty()
    {
        $this->model->email = 'name@domain.com';
        $this->assertEquals('name@domain.com', $this->model->email);
    }

    public function testGetPluralEntityName()
    {
        $this->assertEquals('modelstubs', $this->model->base()->lowercase()->plural());
    }

    public function testValidatingFailsWithMissingRequiredEmail()
    {
        $this->assertFalse($this->model->validate());
    }

    public function testValidatingPassesWithRequiredEmail()
    {
        $this->model->email = 'name@domain.com';
        $this->assertTrue($this->model->validate());
    }
}

class ModelStub extends Habil\Bcoin\Model
{
    use \Habil\Bcoin\Querying\Findable, \Habil\Bcoin\Serializable;

    protected $fillable = ['name', 'email'];

    protected $rules = ['email' => 'required'];

    protected $queryableOptions = ['plural' => 'the_plural_name'];

    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);
    }
}