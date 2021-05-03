<?php

use App\Models\Assemblyman;
use App\Repositories\AssemblymanRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssemblymanRepositoryTest extends TestCase
{
    use MakeAssemblymanTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AssemblymanRepository
     */
    protected $assemblymanRepo;

    public function setUp()
    {
        parent::setUp();
        $this->assemblymanRepo = App::make(AssemblymanRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateAssemblyman()
    {
        $assemblyman = $this->fakeAssemblymanData();
        $createdAssemblyman = $this->assemblymanRepo->create($assemblyman);
        $createdAssemblyman = $createdAssemblyman->toArray();
        $this->assertArrayHasKey('id', $createdAssemblyman);
        $this->assertNotNull($createdAssemblyman['id'], 'Created Assemblyman must have id specified');
        $this->assertNotNull(Assemblyman::find($createdAssemblyman['id']), 'Assemblyman with given id must be in DB');
        $this->assertModelData($assemblyman, $createdAssemblyman);
    }

    /**
     * @test read
     */
    public function testReadAssemblyman()
    {
        $assemblyman = $this->makeAssemblyman();
        $dbAssemblyman = $this->assemblymanRepo->find($assemblyman->id);
        $dbAssemblyman = $dbAssemblyman->toArray();
        $this->assertModelData($assemblyman->toArray(), $dbAssemblyman);
    }

    /**
     * @test update
     */
    public function testUpdateAssemblyman()
    {
        $assemblyman = $this->makeAssemblyman();
        $fakeAssemblyman = $this->fakeAssemblymanData();
        $updatedAssemblyman = $this->assemblymanRepo->update($fakeAssemblyman, $assemblyman->id);
        $this->assertModelData($fakeAssemblyman, $updatedAssemblyman->toArray());
        $dbAssemblyman = $this->assemblymanRepo->find($assemblyman->id);
        $this->assertModelData($fakeAssemblyman, $dbAssemblyman->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteAssemblyman()
    {
        $assemblyman = $this->makeAssemblyman();
        $resp = $this->assemblymanRepo->delete($assemblyman->id);
        $this->assertTrue($resp);
        $this->assertNull(Assemblyman::find($assemblyman->id), 'Assemblyman should not exist in DB');
    }
}
