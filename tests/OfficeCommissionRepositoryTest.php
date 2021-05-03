<?php

use App\Models\OfficeCommission;
use App\Repositories\OfficeCommissionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OfficeCommissionRepositoryTest extends TestCase
{
    use MakeOfficeCommissionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var OfficeCommissionRepository
     */
    protected $officeCommissionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->officeCommissionRepo = App::make(OfficeCommissionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateOfficeCommission()
    {
        $officeCommission = $this->fakeOfficeCommissionData();
        $createdOfficeCommission = $this->officeCommissionRepo->create($officeCommission);
        $createdOfficeCommission = $createdOfficeCommission->toArray();
        $this->assertArrayHasKey('id', $createdOfficeCommission);
        $this->assertNotNull($createdOfficeCommission['id'], 'Created OfficeCommission must have id specified');
        $this->assertNotNull(OfficeCommission::find($createdOfficeCommission['id']), 'OfficeCommission with given id must be in DB');
        $this->assertModelData($officeCommission, $createdOfficeCommission);
    }

    /**
     * @test read
     */
    public function testReadOfficeCommission()
    {
        $officeCommission = $this->makeOfficeCommission();
        $dbOfficeCommission = $this->officeCommissionRepo->find($officeCommission->id);
        $dbOfficeCommission = $dbOfficeCommission->toArray();
        $this->assertModelData($officeCommission->toArray(), $dbOfficeCommission);
    }

    /**
     * @test update
     */
    public function testUpdateOfficeCommission()
    {
        $officeCommission = $this->makeOfficeCommission();
        $fakeOfficeCommission = $this->fakeOfficeCommissionData();
        $updatedOfficeCommission = $this->officeCommissionRepo->update($fakeOfficeCommission, $officeCommission->id);
        $this->assertModelData($fakeOfficeCommission, $updatedOfficeCommission->toArray());
        $dbOfficeCommission = $this->officeCommissionRepo->find($officeCommission->id);
        $this->assertModelData($fakeOfficeCommission, $dbOfficeCommission->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteOfficeCommission()
    {
        $officeCommission = $this->makeOfficeCommission();
        $resp = $this->officeCommissionRepo->delete($officeCommission->id);
        $this->assertTrue($resp);
        $this->assertNull(OfficeCommission::find($officeCommission->id), 'OfficeCommission should not exist in DB');
    }
}
