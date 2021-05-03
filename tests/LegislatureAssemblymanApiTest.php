<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LegislatureAssemblymanApiTest extends TestCase
{
    use MakeLegislatureAssemblymanTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->fakeLegislatureAssemblymanData();
        $this->json('POST', '/api/v1/legislatureAssemblymen', $legislatureAssemblyman);

        $this->assertApiResponse($legislatureAssemblyman);
    }

    /**
     * @test
     */
    public function testReadLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->makeLegislatureAssemblyman();
        $this->json('GET', '/api/v1/legislatureAssemblymen/'.$legislatureAssemblyman->id);

        $this->assertApiResponse($legislatureAssemblyman->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->makeLegislatureAssemblyman();
        $editedLegislatureAssemblyman = $this->fakeLegislatureAssemblymanData();

        $this->json('PUT', '/api/v1/legislatureAssemblymen/'.$legislatureAssemblyman->id, $editedLegislatureAssemblyman);

        $this->assertApiResponse($editedLegislatureAssemblyman);
    }

    /**
     * @test
     */
    public function testDeleteLegislatureAssemblyman()
    {
        $legislatureAssemblyman = $this->makeLegislatureAssemblyman();
        $this->json('DELETE', '/api/v1/legislatureAssemblymen/'.$legislatureAssemblyman->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/legislatureAssemblymen/'.$legislatureAssemblyman->id);

        $this->assertResponseStatus(404);
    }
}
