<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PartyApiTest extends TestCase
{
    use MakePartyTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateParty()
    {
        $party = $this->fakePartyData();
        $this->json('POST', '/api/v1/parties', $party);

        $this->assertApiResponse($party);
    }

    /**
     * @test
     */
    public function testReadParty()
    {
        $party = $this->makeParty();
        $this->json('GET', '/api/v1/parties/'.$party->id);

        $this->assertApiResponse($party->toArray());
    }

    /**
     * @test
     */
    public function testUpdateParty()
    {
        $party = $this->makeParty();
        $editedParty = $this->fakePartyData();

        $this->json('PUT', '/api/v1/parties/'.$party->id, $editedParty);

        $this->assertApiResponse($editedParty);
    }

    /**
     * @test
     */
    public function testDeleteParty()
    {
        $party = $this->makeParty();
        $this->json('DELETE', '/api/v1/parties/'.$party->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/parties/'.$party->id);

        $this->assertResponseStatus(404);
    }
}
