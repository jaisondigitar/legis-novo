<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionTypeApiTest extends TestCase
{
    use MakeSessionTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSessionType()
    {
        $sessionType = $this->fakeSessionTypeData();
        $this->json('POST', '/api/v1/sessionTypes', $sessionType);

        $this->assertApiResponse($sessionType);
    }

    /**
     * @test
     */
    public function testReadSessionType()
    {
        $sessionType = $this->makeSessionType();
        $this->json('GET', '/api/v1/sessionTypes/'.$sessionType->id);

        $this->assertApiResponse($sessionType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSessionType()
    {
        $sessionType = $this->makeSessionType();
        $editedSessionType = $this->fakeSessionTypeData();

        $this->json('PUT', '/api/v1/sessionTypes/'.$sessionType->id, $editedSessionType);

        $this->assertApiResponse($editedSessionType);
    }

    /**
     * @test
     */
    public function testDeleteSessionType()
    {
        $sessionType = $this->makeSessionType();
        $this->json('DELETE', '/api/v1/sessionTypes/'.$sessionType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/sessionTypes/'.$sessionType->id);

        $this->assertResponseStatus(404);
    }
}
