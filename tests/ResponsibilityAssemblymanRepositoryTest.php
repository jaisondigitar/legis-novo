<?php

use App\Models\ResponsibilityAssemblyman;
use App\Repositories\ResponsibilityAssemblymanRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponsibilityAssemblymanRepositoryTest extends TestCase
{
    use MakeResponsibilityAssemblymanTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ResponsibilityAssemblymanRepository
     */
    protected $responsibilityAssemblymanRepo;

    public function setUp()
    {
        parent::setUp();
        $this->responsibilityAssemblymanRepo = App::make(ResponsibilityAssemblymanRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->fakeResponsibilityAssemblymanData();
        $createdResponsibilityAssemblyman = $this->responsibilityAssemblymanRepo->create($responsibilityAssemblyman);
        $createdResponsibilityAssemblyman = $createdResponsibilityAssemblyman->toArray();
        $this->assertArrayHasKey('id', $createdResponsibilityAssemblyman);
        $this->assertNotNull($createdResponsibilityAssemblyman['id'], 'Created ResponsibilityAssemblyman must have id specified');
        $this->assertNotNull(ResponsibilityAssemblyman::find($createdResponsibilityAssemblyman['id']), 'ResponsibilityAssemblyman with given id must be in DB');
        $this->assertModelData($responsibilityAssemblyman, $createdResponsibilityAssemblyman);
    }

    /**
     * @test read
     */
    public function testReadResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->makeResponsibilityAssemblyman();
        $dbResponsibilityAssemblyman = $this->responsibilityAssemblymanRepo->find($responsibilityAssemblyman->id);
        $dbResponsibilityAssemblyman = $dbResponsibilityAssemblyman->toArray();
        $this->assertModelData($responsibilityAssemblyman->toArray(), $dbResponsibilityAssemblyman);
    }

    /**
     * @test update
     */
    public function testUpdateResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->makeResponsibilityAssemblyman();
        $fakeResponsibilityAssemblyman = $this->fakeResponsibilityAssemblymanData();
        $updatedResponsibilityAssemblyman = $this->responsibilityAssemblymanRepo->update($fakeResponsibilityAssemblyman, $responsibilityAssemblyman->id);
        $this->assertModelData($fakeResponsibilityAssemblyman, $updatedResponsibilityAssemblyman->toArray());
        $dbResponsibilityAssemblyman = $this->responsibilityAssemblymanRepo->find($responsibilityAssemblyman->id);
        $this->assertModelData($fakeResponsibilityAssemblyman, $dbResponsibilityAssemblyman->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->makeResponsibilityAssemblyman();
        $resp = $this->responsibilityAssemblymanRepo->delete($responsibilityAssemblyman->id);
        $this->assertTrue($resp);
        $this->assertNull(ResponsibilityAssemblyman::find($responsibilityAssemblyman->id), 'ResponsibilityAssemblyman should not exist in DB');
    }
}
