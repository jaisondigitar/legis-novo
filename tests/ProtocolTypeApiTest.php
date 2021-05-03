<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProtocolTypeApiTest extends TestCase
{
    use MakeProtocolTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProtocolType()
    {
        $protocolType = $this->fakeProtocolTypeData();
        $this->json('POST', '/api/v1/protocolTypes', $protocolType);

        $this->assertApiResponse($protocolType);
    }

    /**
     * @test
     */
    public function testReadProtocolType()
    {
        $protocolType = $this->makeProtocolType();
        $this->json('GET', '/api/v1/protocolTypes/'.$protocolType->id);

        $this->assertApiResponse($protocolType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProtocolType()
    {
        $protocolType = $this->makeProtocolType();
        $editedProtocolType = $this->fakeProtocolTypeData();

        $this->json('PUT', '/api/v1/protocolTypes/'.$protocolType->id, $editedProtocolType);

        $this->assertApiResponse($editedProtocolType);
    }

    /**
     * @test
     */
    public function testDeleteProtocolType()
    {
        $protocolType = $this->makeProtocolType();
        $this->json('DELETE', '/api/v1/protocolTypes/'.$protocolType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/protocolTypes/'.$protocolType->id);

        $this->assertResponseStatus(404);
    }
}
