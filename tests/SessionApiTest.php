<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionApiTest extends TestCase
{
    use MakeSessionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSession()
    {
        $session = $this->fakeSessionData();
        $this->json('POST', '/api/v1/sessions', $session);

        $this->assertApiResponse($session);
    }

    /**
     * @test
     */
    public function testReadSession()
    {
        $session = $this->makeSession();
        $this->json('GET', '/api/v1/sessions/'.$session->id);

        $this->assertApiResponse($session->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSession()
    {
        $session = $this->makeSession();
        $editedSession = $this->fakeSessionData();

        $this->json('PUT', '/api/v1/sessions/'.$session->id, $editedSession);

        $this->assertApiResponse($editedSession);
    }

    /**
     * @test
     */
    public function testDeleteSession()
    {
        $session = $this->makeSession();
        $this->json('DELETE', '/api/v1/sessions/'.$session->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/sessions/'.$session->id);

        $this->assertResponseStatus(404);
    }
}
