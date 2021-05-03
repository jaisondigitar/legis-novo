<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LegislatureApiTest extends TestCase
{
    use MakeLegislatureTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateLegislature()
    {
        $legislature = $this->fakeLegislatureData();
        $this->json('POST', '/api/v1/legislatures', $legislature);

        $this->assertApiResponse($legislature);
    }

    /**
     * @test
     */
    public function testReadLegislature()
    {
        $legislature = $this->makeLegislature();
        $this->json('GET', '/api/v1/legislatures/'.$legislature->id);

        $this->assertApiResponse($legislature->toArray());
    }

    /**
     * @test
     */
    public function testUpdateLegislature()
    {
        $legislature = $this->makeLegislature();
        $editedLegislature = $this->fakeLegislatureData();

        $this->json('PUT', '/api/v1/legislatures/'.$legislature->id, $editedLegislature);

        $this->assertApiResponse($editedLegislature);
    }

    /**
     * @test
     */
    public function testDeleteLegislature()
    {
        $legislature = $this->makeLegislature();
        $this->json('DELETE', '/api/v1/legislatures/'.$legislature->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/legislatures/'.$legislature->id);

        $this->assertResponseStatus(404);
    }
}
