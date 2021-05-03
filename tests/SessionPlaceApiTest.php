<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionPlaceApiTest extends TestCase
{
    use MakeSessionPlaceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSessionPlace()
    {
        $sessionPlace = $this->fakeSessionPlaceData();
        $this->json('POST', '/api/v1/sessionPlaces', $sessionPlace);

        $this->assertApiResponse($sessionPlace);
    }

    /**
     * @test
     */
    public function testReadSessionPlace()
    {
        $sessionPlace = $this->makeSessionPlace();
        $this->json('GET', '/api/v1/sessionPlaces/'.$sessionPlace->id);

        $this->assertApiResponse($sessionPlace->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSessionPlace()
    {
        $sessionPlace = $this->makeSessionPlace();
        $editedSessionPlace = $this->fakeSessionPlaceData();

        $this->json('PUT', '/api/v1/sessionPlaces/'.$sessionPlace->id, $editedSessionPlace);

        $this->assertApiResponse($editedSessionPlace);
    }

    /**
     * @test
     */
    public function testDeleteSessionPlace()
    {
        $sessionPlace = $this->makeSessionPlace();
        $this->json('DELETE', '/api/v1/sessionPlaces/'.$sessionPlace->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/sessionPlaces/'.$sessionPlace->id);

        $this->assertResponseStatus(404);
    }
}
