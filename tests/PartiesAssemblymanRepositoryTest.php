<?php

use App\Models\PartiesAssemblyman;
use App\Repositories\PartiesAssemblymanRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PartiesAssemblymanRepositoryTest extends TestCase
{
    use MakePartiesAssemblymanTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PartiesAssemblymanRepository
     */
    protected $partiesAssemblymanRepo;

    public function setUp()
    {
        parent::setUp();
        $this->partiesAssemblymanRepo = App::make(PartiesAssemblymanRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePartiesAssemblyman()
    {
        $partiesAssemblyman = $this->fakePartiesAssemblymanData();
        $createdPartiesAssemblyman = $this->partiesAssemblymanRepo->create($partiesAssemblyman);
        $createdPartiesAssemblyman = $createdPartiesAssemblyman->toArray();
        $this->assertArrayHasKey('id', $createdPartiesAssemblyman);
        $this->assertNotNull($createdPartiesAssemblyman['id'], 'Created PartiesAssemblyman must have id specified');
        $this->assertNotNull(PartiesAssemblyman::find($createdPartiesAssemblyman['id']), 'PartiesAssemblyman with given id must be in DB');
        $this->assertModelData($partiesAssemblyman, $createdPartiesAssemblyman);
    }

    /**
     * @test read
     */
    public function testReadPartiesAssemblyman()
    {
        $partiesAssemblyman = $this->makePartiesAssemblyman();
        $dbPartiesAssemblyman = $this->partiesAssemblymanRepo->find($partiesAssemblyman->id);
        $dbPartiesAssemblyman = $dbPartiesAssemblyman->toArray();
        $this->assertModelData($partiesAssemblyman->toArray(), $dbPartiesAssemblyman);
    }

    /**
     * @test update
     */
    public function testUpdatePartiesAssemblyman()
    {
        $partiesAssemblyman = $this->makePartiesAssemblyman();
        $fakePartiesAssemblyman = $this->fakePartiesAssemblymanData();
        $updatedPartiesAssemblyman = $this->partiesAssemblymanRepo->update($fakePartiesAssemblyman, $partiesAssemblyman->id);
        $this->assertModelData($fakePartiesAssemblyman, $updatedPartiesAssemblyman->toArray());
        $dbPartiesAssemblyman = $this->partiesAssemblymanRepo->find($partiesAssemblyman->id);
        $this->assertModelData($fakePartiesAssemblyman, $dbPartiesAssemblyman->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePartiesAssemblyman()
    {
        $partiesAssemblyman = $this->makePartiesAssemblyman();
        $resp = $this->partiesAssemblymanRepo->delete($partiesAssemblyman->id);
        $this->assertTrue($resp);
        $this->assertNull(PartiesAssemblyman::find($partiesAssemblyman->id), 'PartiesAssemblyman should not exist in DB');
    }
}
