<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentModelsApiTest extends TestCase
{
    use MakeDocumentModelsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDocumentModels()
    {
        $documentModels = $this->fakeDocumentModelsData();
        $this->json('POST', '/api/v1/documentModels', $documentModels);

        $this->assertApiResponse($documentModels);
    }

    /**
     * @test
     */
    public function testReadDocumentModels()
    {
        $documentModels = $this->makeDocumentModels();
        $this->json('GET', '/api/v1/documentModels/'.$documentModels->id);

        $this->assertApiResponse($documentModels->toArray());
    }

    /**
     * @test
     */
    public function testUpdateDocumentModels()
    {
        $documentModels = $this->makeDocumentModels();
        $editedDocumentModels = $this->fakeDocumentModelsData();

        $this->json('PUT', '/api/v1/documentModels/'.$documentModels->id, $editedDocumentModels);

        $this->assertApiResponse($editedDocumentModels);
    }

    /**
     * @test
     */
    public function testDeleteDocumentModels()
    {
        $documentModels = $this->makeDocumentModels();
        $this->json('DELETE', '/api/v1/documentModels/'.$documentModels->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/documentModels/'.$documentModels->id);

        $this->assertResponseStatus(404);
    }
}
