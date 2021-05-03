<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommissionApiTest extends TestCase
{
    use MakeCommissionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCommission()
    {
        $commission = $this->fakeCommissionData();
        $this->json('POST', '/api/v1/commissions', $commission);

        $this->assertApiResponse($commission);
    }

    /**
     * @test
     */
    public function testReadCommission()
    {
        $commission = $this->makeCommission();
        $this->json('GET', '/api/v1/commissions/'.$commission->id);

        $this->assertApiResponse($commission->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCommission()
    {
        $commission = $this->makeCommission();
        $editedCommission = $this->fakeCommissionData();

        $this->json('PUT', '/api/v1/commissions/'.$commission->id, $editedCommission);

        $this->assertApiResponse($editedCommission);
    }

    /**
     * @test
     */
    public function testDeleteCommission()
    {
        $commission = $this->makeCommission();
        $this->json('DELETE', '/api/v1/commissions/'.$commission->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/commissions/'.$commission->id);

        $this->assertResponseStatus(404);
    }
}
