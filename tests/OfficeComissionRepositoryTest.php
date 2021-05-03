<?php

use App\Models\OfficeComission;
use App\Repositories\OfficeComissionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OfficeComissionRepositoryTest extends TestCase
{
    use MakeOfficeComissionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var OfficeComissionRepository
     */
    protected $officeComissionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->officeComissionRepo = App::make(OfficeComissionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateOfficeComission()
    {
        $officeComission = $this->fakeOfficeComissionData();
        $createdOfficeComission = $this->officeComissionRepo->create($officeComission);
        $createdOfficeComission = $createdOfficeComission->toArray();
        $this->assertArrayHasKey('id', $createdOfficeComission);
        $this->assertNotNull($createdOfficeComission['id'], 'Created OfficeComission must have id specified');
        $this->assertNotNull(OfficeComission::find($createdOfficeComission['id']), 'OfficeComission with given id must be in DB');
        $this->assertModelData($officeComission, $createdOfficeComission);
    }

    /**
     * @test read
     */
    public function testReadOfficeComission()
    {
        $officeComission = $this->makeOfficeComission();
        $dbOfficeComission = $this->officeComissionRepo->find($officeComission->id);
        $dbOfficeComission = $dbOfficeComission->toArray();
        $this->assertModelData($officeComission->toArray(), $dbOfficeComission);
    }

    /**
     * @test update
     */
    public function testUpdateOfficeComission()
    {
        $officeComission = $this->makeOfficeComission();
        $fakeOfficeComission = $this->fakeOfficeComissionData();
        $updatedOfficeComission = $this->officeComissionRepo->update($fakeOfficeComission, $officeComission->id);
        $this->assertModelData($fakeOfficeComission, $updatedOfficeComission->toArray());
        $dbOfficeComission = $this->officeComissionRepo->find($officeComission->id);
        $this->assertModelData($fakeOfficeComission, $dbOfficeComission->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteOfficeComission()
    {
        $officeComission = $this->makeOfficeComission();
        $resp = $this->officeComissionRepo->delete($officeComission->id);
        $this->assertTrue($resp);
        $this->assertNull(OfficeComission::find($officeComission->id), 'OfficeComission should not exist in DB');
    }
}
