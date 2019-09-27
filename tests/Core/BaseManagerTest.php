<?php namespace Test\Core;

use App\Entities\User;
use CodeIgniter\Entity;
use Mockery as m;
use App\Core\BaseManager;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\UserModel;

class BaseManagerTest extends CIDatabaseTestCase
{
    protected $refresh = false;

    /**
     * @var BaseManager
     */
    protected $manager;

    /**
     * @var UserModel
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->manager = new BaseManager();
        $this->model = m::mock(UserModel::class)->makePartial();
        $this->manager->setModel($this->model);
        $this->manager->populateColumns();
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    public function testCanSetPropertyDirectly()
    {
        $this->assertNull($this->manager->username);

        $this->manager->username = 'Fred';

        $this->assertEquals('Fred', $this->manager->username);
    }

    /**
     * @expectedException \App\Exceptions\DataException
     * @expectedExceptionMessage Sorry, unable to find that Thing.
     * @expectedExceptionCode 404
     */
    public function testFindThrowsWhenNotFound()
    {
        $this->model->shouldReceive('find')->once()->with(3)->andReturn(null);

        $this->manager->find(3);
    }

    public function testFindReturnsModel()
    {
        $this->model->shouldReceive('find')->once()->with(3)->andReturn($this->model);

        $result = $this->manager->find(3);

        $this->assertEquals($result, $this->model);
    }

    /**
     * @expectedException \App\Exceptions\DataException
     * @expectedExceptionMessage Sorry, unable to find any Thing records that match your criteria.
     * @expectedExceptionCode 404
     */
    public function testFindWhereThrowsWhenNotFound()
    {
        $this->model->shouldReceive('where')->once()->with(\Mockery::subset(['foo' => 'bar']))->andReturn($this->model);
        $this->model->shouldReceive('findAll')->once()->andReturn(null);

        $this->manager->findWhere(['foo' => 'bar']);
    }

    public function testFindWhereSuccess()
    {
        $this->model->shouldReceive('where')->once()->with(\Mockery::subset(['foo' => 'bar']))->andReturn($this->model);
        $this->model->shouldReceive('findAll')->once()->andReturn($this->model);

        $response = $this->manager->findWhere(['foo' => 'bar']);

        $this->assertEquals($response, $this->model);
    }

    public function testDeleteSuccess()
    {
        $this->model->shouldReceive('find')->once()->with(3)->andReturn($this->model);
        $this->model->shouldReceive('delete')->once()->andReturn(true);

        $this->assertTrue($this->manager->delete(3));
    }

    public function testCreateSuccess()
    {
        $username = 'Fred';
        $email = 'bedrockFred@example.com';

        $this->model->shouldReceive('insert')->once()->with(\Mockery::subset([
            'username' => $username,
            'email' => $email,
        ]))->andReturn(true);
        $this->model->skipValidation(true);

        $result = $this->manager
            ->set('username', $username)
            ->set('email', $email)
            ->create();

        $this->assertTrue($result);
    }
}
