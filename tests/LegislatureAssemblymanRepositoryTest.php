<?php

use App\Models\LegislatureAssemblyman;
use App\Repositories\LegislatureAssemblymanRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LegislatureAssemblymanRepositoryTest extends TestCase
{
    use MakeLegislatureAssemblymanTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LegislatureAssemblymanRepository
     */
    protected $legislatureAssemblymanRepo;

    public function setUp()
    {
        parent::setUp();
        $this->legislatureAssemblymanRepo = App::make(LegislatureAssemblymanRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->fakeLegislatureAssemblymanData();
        $createdLegislatureAssemblyman = $this->legislatureAssemblymanRepo->create($legislatureAssemblyman);
        $createdLegislatureAssemblyman = $createdLegislatureAssemblyman->toArray();
        $this->assertArrayHasKey('id', $createdLegislatureAssemblyman);
        $this->assertNotNull($createdLegislatureAssemblyman['id'], 'Created LegislatureAssemblyman must have id specified');
        $this->assertNotNull(LegislatureAssemblyman::find($createdLegislatureAssemblyman['id']), 'LegislatureAssemblyman with given id must be in DB');
        $this->assertModelData($legislatureAssemblyman, $createdLegislatureAssemblyman);
    }

    /**
     * @test read
     */
    public function testReadLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->makeLegislatureAssemblyman();
        $dbLegislatureAssemblyman = $this->legislatureAssemblymanRepo->find($legislatureAssemblyman->id);
        $dbLegislatureAssemblyman = $dbLegislatureAssemblyman->toArray();
        $this->assertModelData($legislatureAssemblyman->toArray(), $dbLegislatureAssemblyman);
    }

    /**
     * @test update
     */
    public function testUpdateLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->makeLegislatureAssemblyman();
        $fakeLegislatureAssemblyman = $this->fakeLegislatureAssemblymanData();
        $updatedLegislatureAssemblyman = $this->legislatureAssemblymanRepo->update($fakeLegislatureAssemblyman, $legislatureAssemblyman->id);
        $this->assertModelData($fakeLegislatureAssemblyman, $updatedLegislatureAssemblyman->toArray());
        $dbLegislatureAssemblyman = $this->legislatureAssemblymanRepo->find($legislatureAssemblyman->id);
        $this->assertModelData($fakeLegislatureAssemblyman, $dbLegislatureAssemblyman->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->makeLegislatureAssemblyman();
        $resp = $this->legislatureAssemblymanRepo->delete($legislatureAssemblyman->id);
        $this->assertTrue($resp);
        $this->assertNull(LegislatureAssemblyman::find($legislatureAssemblyman->id), 'LegislatureAssemblyman should not exist in DB');
    }
}
