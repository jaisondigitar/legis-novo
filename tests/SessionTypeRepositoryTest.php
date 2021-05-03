<?php

use App\Models\SessionType;
use App\Repositories\SessionTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionTypeRepositoryTest extends TestCase
{
    use MakeSessionTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SessionTypeRepository
     */
    protected $sessionTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->sessionTypeRepo = App::make(SessionTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSessionType()
    {
        $sessionType = $this->fakeSessionTypeData();
        $createdSessionType = $this->sessionTypeRepo->create($sessionType);
        $createdSessionType = $createdSessionType->toArray();
        $this->assertArrayHasKey('id', $createdSessionType);
        $this->assertNotNull($createdSessionType['id'], 'Created SessionType must have id specified');
        $this->assertNotNull(SessionType::find($createdSessionType['id']), 'SessionType with given id must be in DB');
        $this->assertModelData($sessionType, $createdSessionType);
    }

    /**
     * @test read
     */
    public function testReadSessionType()
    {
        $sessionType = $this->makeSessionType();
        $dbSessionType = $this->sessionTypeRepo->find($sessionType->id);
        $dbSessionType = $dbSessionType->toArray();
        $this->assertModelData($sessionType->toArray(), $dbSessionType);
    }

    /**
     * @test update
     */
    public function testUpdateSessionType()
    {
        $sessionType = $this->makeSessionType();
        $fakeSessionType = $this->fakeSessionTypeData();
        $updatedSessionType = $this->sessionTypeRepo->update($fakeSessionType, $sessionType->id);
        $this->assertModelData($fakeSessionType, $updatedSessionType->toArray());
        $dbSessionType = $this->sessionTypeRepo->find($sessionType->id);
        $this->assertModelData($fakeSessionType, $dbSessionType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSessionType()
    {
        $sessionType = $this->makeSessionType();
        $resp = $this->sessionTypeRepo->delete($sessionType->id);
        $this->assertTrue($resp);
        $this->assertNull(SessionType::find($sessionType->id), 'SessionType should not exist in DB');
    }
}
