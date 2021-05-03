<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OfficeComissionApiTest extends TestCase
{
    use MakeOfficeComissionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateOfficeComission()
    {
        $officeComission = $this->fakeOfficeComissionData();
        $this->json('POST', '/api/v1/officeComissions', $officeComission);

        $this->assertApiResponse($officeComission);
    }

    /**
     * @test
     */
    public function testReadOfficeComission()
    {
        $officeComission = $this->makeOfficeComission();
        $this->json('GET', '/api/v1/officeComissions/'.$officeComission->id);

        $this->assertApiResponse($officeComission->toArray());
    }

    /**
     * @test
     */
    public function testUpdateOfficeComission()
    {
        $officeComission = $this->makeOfficeComission();
        $editedOfficeComission = $this->fakeOfficeComissionData();

        $this->json('PUT', '/api/v1/officeComissions/'.$officeComission->id, $editedOfficeComission);

        $this->assertApiResponse($editedOfficeComission);
    }

    /**
     * @test
     */
    public function testDeleteOfficeComission()
    {
        $officeComission = $this->makeOfficeComission();
        $this->json('DELETE', '/api/v1/officeComissions/'.$officeComission->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/officeComissions/'.$officeComission->id);

        $this->assertResponseStatus(404);
    }
}
