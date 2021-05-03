<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponsibilityApiTest extends TestCase
{
    use MakeResponsibilityTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateResponsibility()
    {
        $responsibility = $this->fakeResponsibilityData();
        $this->json('POST', '/api/v1/responsibilities', $responsibility);

        $this->assertApiResponse($responsibility);
    }

    /**
     * @test
     */
    public function testReadResponsibility()
    {
        $responsibility = $this->makeResponsibility();
        $this->json('GET', '/api/v1/responsibilities/'.$responsibility->id);

        $this->assertApiResponse($responsibility->toArray());
    }

    /**
     * @test
     */
    public function testUpdateResponsibility()
    {
        $responsibility = $this->makeResponsibility();
        $editedResponsibility = $this->fakeResponsibilityData();

        $this->json('PUT', '/api/v1/responsibilities/'.$responsibility->id, $editedResponsibility);

        $this->assertApiResponse($editedResponsibility);
    }

    /**
     * @test
     */
    public function testDeleteResponsibility()
    {
        $responsibility = $this->makeResponsibility();
        $this->json('DELETE', '/api/v1/responsibilities/'.$responsibility->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/responsibilities/'.$responsibility->id);

        $this->assertResponseStatus(404);
    }
}
