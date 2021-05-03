<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponsibilityAssemblymanApiTest extends TestCase
{
    use MakeResponsibilityAssemblymanTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->fakeResponsibilityAssemblymanData();
        $this->json('POST', '/api/v1/responsibilityAssemblymen', $responsibilityAssemblyman);

        $this->assertApiResponse($responsibilityAssemblyman);
    }

    /**
     * @test
     */
    public function testReadResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->makeResponsibilityAssemblyman();
        $this->json('GET', '/api/v1/responsibilityAssemblymen/'.$responsibilityAssemblyman->id);

        $this->assertApiResponse($responsibilityAssemblyman->toArray());
    }

    /**
     * @test
     */
    public function testUpdateResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->makeResponsibilityAssemblyman();
        $editedResponsibilityAssemblyman = $this->fakeResponsibilityAssemblymanData();

        $this->json('PUT', '/api/v1/responsibilityAssemblymen/'.$responsibilityAssemblyman->id, $editedResponsibilityAssemblyman);

        $this->assertApiResponse($editedResponsibilityAssemblyman);
    }

    /**
     * @test
     */
    public function testDeleteResponsibilityAssemblyman()
    {
        $responsibilityAssemblyman = $this->makeResponsibilityAssemblyman();
        $this->json('DELETE', '/api/v1/responsibilityAssemblymen/'.$responsibilityAssemblyman->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/responsibilityAssemblymen/'.$responsibilityAssemblyman->id);

        $this->assertResponseStatus(404);
    }
}
