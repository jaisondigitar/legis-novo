<?php

use App\Models\SessionPlace;
use App\Repositories\SessionPlaceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionPlaceRepositoryTest extends TestCase
{
    use MakeSessionPlaceTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SessionPlaceRepository
     */
    protected $sessionPlaceRepo;

    public function setUp()
    {
        parent::setUp();
        $this->sessionPlaceRepo = App::make(SessionPlaceRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSessionPlace()
    {
        $sessionPlace = $this->fakeSessionPlaceData();
        $createdSessionPlace = $this->sessionPlaceRepo->create($sessionPlace);
        $createdSessionPlace = $createdSessionPlace->toArray();
        $this->assertArrayHasKey('id', $createdSessionPlace);
        $this->assertNotNull($createdSessionPlace['id'], 'Created SessionPlace must have id specified');
        $this->assertNotNull(SessionPlace::find($createdSessionPlace['id']), 'SessionPlace with given id must be in DB');
        $this->assertModelData($sessionPlace, $createdSessionPlace);
    }

    /**
     * @test read
     */
    public function testReadSessionPlace()
    {
        $sessionPlace = $this->makeSessionPlace();
        $dbSessionPlace = $this->sessionPlaceRepo->find($sessionPlace->id);
        $dbSessionPlace = $dbSessionPlace->toArray();
        $this->assertModelData($sessionPlace->toArray(), $dbSessionPlace);
    }

    /**
     * @test update
     */
    public function testUpdateSessionPlace()
    {
        $sessionPlace = $this->makeSessionPlace();
        $fakeSessionPlace = $this->fakeSessionPlaceData();
        $updatedSessionPlace = $this->sessionPlaceRepo->update($fakeSessionPlace, $sessionPlace->id);
        $this->assertModelData($fakeSessionPlace, $updatedSessionPlace->toArray());
        $dbSessionPlace = $this->sessionPlaceRepo->find($sessionPlace->id);
        $this->assertModelData($fakeSessionPlace, $dbSessionPlace->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSessionPlace()
    {
        $sessionPlace = $this->makeSessionPlace();
        $resp = $this->sessionPlaceRepo->delete($sessionPlace->id);
        $this->assertTrue($resp);
        $this->assertNull(SessionPlace::find($sessionPlace->id), 'SessionPlace should not exist in DB');
    }
}
