<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssemblymanApiTest extends TestCase
{
    use MakeAssemblymanTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateAssemblyman()
    {
        $assemblyman = $this->fakeAssemblymanData();
        $this->json('POST', '/api/v1/assemblymen', $assemblyman);

        $this->assertApiResponse($assemblyman);
    }

    /**
     * @test
     */
    public function testReadAssemblyman()
    {
        $assemblyman = $this->makeAssemblyman();
        $this->json('GET', '/api/v1/assemblymen/'.$assemblyman->id);

        $this->assertApiResponse($assemblyman->toArray());
    }

    /**
     * @test
     */
    public function testUpdateAssemblyman()
    {
        $assemblyman = $this->makeAssemblyman();
        $editedAssemblyman = $this->fakeAssemblymanData();

        $this->json('PUT', '/api/v1/assemblymen/'.$assemblyman->id, $editedAssemblyman);

        $this->assertApiResponse($editedAssemblyman);
    }

    /**
     * @test
     */
    public function testDeleteAssemblyman()
    {
        $assemblyman = $this->makeAssemblyman();
        $this->json('DELETE', '/api/v1/assemblymen/'.$assemblyman->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/assemblymen/'.$assemblyman->id);

        $this->assertResponseStatus(404);
    }
}
