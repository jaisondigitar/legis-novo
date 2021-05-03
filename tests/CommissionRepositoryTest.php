<?php

use App\Models\Commission;
use App\Repositories\CommissionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommissionRepositoryTest extends TestCase
{
    use MakeCommissionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CommissionRepository
     */
    protected $commissionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->commissionRepo = App::make(CommissionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCommission()
    {
        $commission = $this->fakeCommissionData();
        $createdCommission = $this->commissionRepo->create($commission);
        $createdCommission = $createdCommission->toArray();
        $this->assertArrayHasKey('id', $createdCommission);
        $this->assertNotNull($createdCommission['id'], 'Created Commission must have id specified');
        $this->assertNotNull(Commission::find($createdCommission['id']), 'Commission with given id must be in DB');
        $this->assertModelData($commission, $createdCommission);
    }

    /**
     * @test read
     */
    public function testReadCommission()
    {
        $commission = $this->makeCommission();
        $dbCommission = $this->commissionRepo->find($commission->id);
        $dbCommission = $dbCommission->toArray();
        $this->assertModelData($commission->toArray(), $dbCommission);
    }

    /**
     * @test update
     */
    public function testUpdateCommission()
    {
        $commission = $this->makeCommission();
        $fakeCommission = $this->fakeCommissionData();
        $updatedCommission = $this->commissionRepo->update($fakeCommission, $commission->id);
        $this->assertModelData($fakeCommission, $updatedCommission->toArray());
        $dbCommission = $this->commissionRepo->find($commission->id);
        $this->assertModelData($fakeCommission, $dbCommission->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCommission()
    {
        $commission = $this->makeCommission();
        $resp = $this->commissionRepo->delete($commission->id);
        $this->assertTrue($resp);
        $this->assertNull(Commission::find($commission->id), 'Commission should not exist in DB');
    }
}
