<?php

use App\Models\Responsibility;
use App\Repositories\ResponsibilityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponsibilityRepositoryTest extends TestCase
{
    use MakeResponsibilityTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ResponsibilityRepository
     */
    protected $responsibilityRepo;

    public function setUp()
    {
        parent::setUp();
        $this->responsibilityRepo = App::make(ResponsibilityRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateResponsibility()
    {
        $responsibility = $this->fakeResponsibilityData();
        $createdResponsibility = $this->responsibilityRepo->create($responsibility);
        $createdResponsibility = $createdResponsibility->toArray();
        $this->assertArrayHasKey('id', $createdResponsibility);
        $this->assertNotNull($createdResponsibility['id'], 'Created Responsibility must have id specified');
        $this->assertNotNull(Responsibility::find($createdResponsibility['id']), 'Responsibility with given id must be in DB');
        $this->assertModelData($responsibility, $createdResponsibility);
    }

    /**
     * @test read
     */
    public function testReadResponsibility()
    {
        $responsibility = $this->makeResponsibility();
        $dbResponsibility = $this->responsibilityRepo->find($responsibility->id);
        $dbResponsibility = $dbResponsibility->toArray();
        $this->assertModelData($responsibility->toArray(), $dbResponsibility);
    }

    /**
     * @test update
     */
    public function testUpdateResponsibility()
    {
        $responsibility = $this->makeResponsibility();
        $fakeResponsibility = $this->fakeResponsibilityData();
        $updatedResponsibility = $this->responsibilityRepo->update($fakeResponsibility, $responsibility->id);
        $this->assertModelData($fakeResponsibility, $updatedResponsibility->toArray());
        $dbResponsibility = $this->responsibilityRepo->find($responsibility->id);
        $this->assertModelData($fakeResponsibility, $dbResponsibility->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteResponsibility()
    {
        $responsibility = $this->makeResponsibility();
        $resp = $this->responsibilityRepo->delete($responsibility->id);
        $this->assertTrue($resp);
        $this->assertNull(Responsibility::find($responsibility->id), 'Responsibility should not exist in DB');
    }
}
