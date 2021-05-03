<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeetingApiTest extends TestCase
{
    use MakeMeetingTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMeeting()
    {
        $meeting = $this->fakeMeetingData();
        $this->json('POST', '/api/v1/meetings', $meeting);

        $this->assertApiResponse($meeting);
    }

    /**
     * @test
     */
    public function testReadMeeting()
    {
        $meeting = $this->makeMeeting();
        $this->json('GET', '/api/v1/meetings/'.$meeting->id);

        $this->assertApiResponse($meeting->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMeeting()
    {
        $meeting = $this->makeMeeting();
        $editedMeeting = $this->fakeMeetingData();

        $this->json('PUT', '/api/v1/meetings/'.$meeting->id, $editedMeeting);

        $this->assertApiResponse($editedMeeting);
    }

    /**
     * @test
     */
    public function testDeleteMeeting()
    {
        $meeting = $this->makeMeeting();
        $this->json('DELETE', '/api/v1/meetings/'.$meeting->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/meetings/'.$meeting->id);

        $this->assertResponseStatus(404);
    }
}
