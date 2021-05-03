<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PartiesAssemblymanApiTest extends TestCase
{
    use MakePartiesAssemblymanTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePartiesAssemblyman()
    {
        $partiesAssemblyman = $this->fakePartiesAssemblymanData();
        $this->json('POST', '/api/v1/partiesAssemblymen', $partiesAssemblyman);

        $this->assertApiResponse($partiesAssemblyman);
    }

    /**
     * @test
     */
    public function testReadPartiesAssemblyman()
    {
        $partiesAssemblyman = $this->makePartiesAssemblyman();
        $this->json('GET', '/api/v1/partiesAssemblymen/'.$partiesAssemblyman->id);

        $this->assertApiResponse($partiesAssemblyman->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePartiesAssemblyman()
    {
        $partiesAssemblyman = $this->makePartiesAssemblyman();
        $editedPartiesAssemblyman = $this->fakePartiesAssemblymanData();

        $this->json('PUT', '/api/v1/partiesAssemblymen/'.$partiesAssemblyman->id, $editedPartiesAssemblyman);

        $this->assertApiResponse($editedPartiesAssemblyman);
    }

    /**
     * @test
     */
    public function testDeletePartiesAssemblyman()
    {
        $partiesAssemblyman = $this->makePartiesAssemblyman();
        $this->json('DELETE', '/api/v1/partiesAssemblymen/'.$partiesAssemblyman->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/partiesAssemblymen/'.$partiesAssemblyman->id);

        $this->assertResponseStatus(404);
    }
}
