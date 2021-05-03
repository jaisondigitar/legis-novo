<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OfficeCommissionApiTest extends TestCase
{
    use MakeOfficeCommissionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateOfficeCommission()
    {
        $officeCommission = $this->fakeOfficeCommissionData();
        $this->json('POST', '/api/v1/officeCommissions', $officeCommission);

        $this->assertApiResponse($officeCommission);
    }

    /**
     * @test
     */
    public function testReadOfficeCommission()
    {
        $officeCommission = $this->makeOfficeCommission();
        $this->json('GET', '/api/v1/officeCommissions/'.$officeCommission->id);

        $this->assertApiResponse($officeCommission->toArray());
    }

    /**
     * @test
     */
    public function testUpdateOfficeCommission()
    {
        $officeCommission = $this->makeOfficeCommission();
        $editedOfficeCommission = $this->fakeOfficeCommissionData();

        $this->json('PUT', '/api/v1/officeCommissions/'.$officeCommission->id, $editedOfficeCommission);

        $this->assertApiResponse($editedOfficeCommission);
    }

    /**
     * @test
     */
    public function testDeleteOfficeCommission()
    {
        $officeCommission = $this->makeOfficeCommission();
        $this->json('DELETE', '/api/v1/officeCommissions/'.$officeCommission->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/officeCommissions/'.$officeCommission->id);

        $this->assertResponseStatus(404);
    }
}
