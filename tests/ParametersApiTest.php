<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParametersApiTest extends TestCase
{
    use MakeParametersTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateParameters()
    {
        $parameters = $this->fakeParametersData();
        $this->json('POST', '/api/v1/parameters', $parameters);

        $this->assertApiResponse($parameters);
    }

    /**
     * @test
     */
    public function testReadParameters()
    {
        $parameters = $this->makeParameters();
        $this->json('GET', '/api/v1/parameters/'.$parameters->id);

        $this->assertApiResponse($parameters->toArray());
    }

    /**
     * @test
     */
    public function testUpdateParameters()
    {
        $parameters = $this->makeParameters();
        $editedParameters = $this->fakeParametersData();

        $this->json('PUT', '/api/v1/parameters/'.$parameters->id, $editedParameters);

        $this->assertApiResponse($editedParameters);
    }

    /**
     * @test
     */
    public function testDeleteParameters()
    {
        $parameters = $this->makeParameters();
        $this->json('DELETE', '/api/v1/parameters/'.$parameters->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/parameters/'.$parameters->id);

        $this->assertResponseStatus(404);
    }
}
