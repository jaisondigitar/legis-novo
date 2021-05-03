<?php

use App\Models\Meeting;
use App\Repositories\MeetingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeetingRepositoryTest extends TestCase
{
    use MakeMeetingTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MeetingRepository
     */
    protected $meetingRepo;

    public function setUp()
    {
        parent::setUp();
        $this->meetingRepo = App::make(MeetingRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMeeting()
    {
        $meeting = $this->fakeMeetingData();
        $createdMeeting = $this->meetingRepo->create($meeting);
        $createdMeeting = $createdMeeting->toArray();
        $this->assertArrayHasKey('id', $createdMeeting);
        $this->assertNotNull($createdMeeting['id'], 'Created Meeting must have id specified');
        $this->assertNotNull(Meeting::find($createdMeeting['id']), 'Meeting with given id must be in DB');
        $this->assertModelData($meeting, $createdMeeting);
    }

    /**
     * @test read
     */
    public function testReadMeeting()
    {
        $meeting = $this->makeMeeting();
        $dbMeeting = $this->meetingRepo->find($meeting->id);
        $dbMeeting = $dbMeeting->toArray();
        $this->assertModelData($meeting->toArray(), $dbMeeting);
    }

    /**
     * @test update
     */
    public function testUpdateMeeting()
    {
        $meeting = $this->makeMeeting();
        $fakeMeeting = $this->fakeMeetingData();
        $updatedMeeting = $this->meetingRepo->update($fakeMeeting, $meeting->id);
        $this->assertModelData($fakeMeeting, $updatedMeeting->toArray());
        $dbMeeting = $this->meetingRepo->find($meeting->id);
        $this->assertModelData($fakeMeeting, $dbMeeting->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMeeting()
    {
        $meeting = $this->makeMeeting();
        $resp = $this->meetingRepo->delete($meeting->id);
        $this->assertTrue($resp);
        $this->assertNull(Meeting::find($meeting->id), 'Meeting should not exist in DB');
    }
}
