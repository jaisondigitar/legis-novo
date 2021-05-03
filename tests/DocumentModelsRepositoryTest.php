<?php

use App\Models\DocumentModels;
use App\Repositories\DocumentModelsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentModelsRepositoryTest extends TestCase
{
    use MakeDocumentModelsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DocumentModelsRepository
     */
    protected $documentModelsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->documentModelsRepo = App::make(DocumentModelsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDocumentModels()
    {
        $documentModels = $this->fakeDocumentModelsData();
        $createdDocumentModels = $this->documentModelsRepo->create($documentModels);
        $createdDocumentModels = $createdDocumentModels->toArray();
        $this->assertArrayHasKey('id', $createdDocumentModels);
        $this->assertNotNull($createdDocumentModels['id'], 'Created DocumentModels must have id specified');
        $this->assertNotNull(DocumentModels::find($createdDocumentModels['id']), 'DocumentModels with given id must be in DB');
        $this->assertModelData($documentModels, $createdDocumentModels);
    }

    /**
     * @test read
     */
    public function testReadDocumentModels()
    {
        $documentModels = $this->makeDocumentModels();
        $dbDocumentModels = $this->documentModelsRepo->find($documentModels->id);
        $dbDocumentModels = $dbDocumentModels->toArray();
        $this->assertModelData($documentModels->toArray(), $dbDocumentModels);
    }

    /**
     * @test update
     */
    public function testUpdateDocumentModels()
    {
        $documentModels = $this->makeDocumentModels();
        $fakeDocumentModels = $this->fakeDocumentModelsData();
        $updatedDocumentModels = $this->documentModelsRepo->update($fakeDocumentModels, $documentModels->id);
        $this->assertModelData($fakeDocumentModels, $updatedDocumentModels->toArray());
        $dbDocumentModels = $this->documentModelsRepo->find($documentModels->id);
        $this->assertModelData($fakeDocumentModels, $dbDocumentModels->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDocumentModels()
    {
        $documentModels = $this->makeDocumentModels();
        $resp = $this->documentModelsRepo->delete($documentModels->id);
        $this->assertTrue($resp);
        $this->assertNull(DocumentModels::find($documentModels->id), 'DocumentModels should not exist in DB');
    }
}
