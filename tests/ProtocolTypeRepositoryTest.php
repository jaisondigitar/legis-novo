<?php

use App\Models\ProtocolType;
use App\Repositories\ProtocolTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProtocolTypeRepositoryTest extends TestCase
{
    use MakeProtocolTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProtocolTypeRepository
     */
    protected $protocolTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->protocolTypeRepo = App::make(ProtocolTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProtocolType()
    {
        $protocolType = $this->fakeProtocolTypeData();
        $createdProtocolType = $this->protocolTypeRepo->create($protocolType);
        $createdProtocolType = $createdProtocolType->toArray();
        $this->assertArrayHasKey('id', $createdProtocolType);
        $this->assertNotNull($createdProtocolType['id'], 'Created ProtocolType must have id specified');
        $this->assertNotNull(ProtocolType::find($createdProtocolType['id']), 'ProtocolType with given id must be in DB');
        $this->assertModelData($protocolType, $createdProtocolType);
    }

    /**
     * @test read
     */
    public function testReadProtocolType()
    {
        $protocolType = $this->makeProtocolType();
        $dbProtocolType = $this->protocolTypeRepo->find($protocolType->id);
        $dbProtocolType = $dbProtocolType->toArray();
        $this->assertModelData($protocolType->toArray(), $dbProtocolType);
    }

    /**
     * @test update
     */
    public function testUpdateProtocolType()
    {
        $protocolType = $this->makeProtocolType();
        $fakeProtocolType = $this->fakeProtocolTypeData();
        $updatedProtocolType = $this->protocolTypeRepo->update($fakeProtocolType, $protocolType->id);
        $this->assertModelData($fakeProtocolType, $updatedProtocolType->toArray());
        $dbProtocolType = $this->protocolTypeRepo->find($protocolType->id);
        $this->assertModelData($fakeProtocolType, $dbProtocolType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProtocolType()
    {
        $protocolType = $this->makeProtocolType();
        $resp = $this->protocolTypeRepo->delete($protocolType->id);
        $this->assertTrue($resp);
        $this->assertNull(ProtocolType::find($protocolType->id), 'ProtocolType should not exist in DB');
    }
}
