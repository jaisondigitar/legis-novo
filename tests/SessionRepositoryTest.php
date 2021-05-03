<?php

use App\Models\Session;
use App\Repositories\SessionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionRepositoryTest extends TestCase
{
    use MakeSessionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SessionRepository
     */
    protected $sessionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->sessionRepo = App::make(SessionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSession()
    {
        $session = $this->fakeSessionData();
        $createdSession = $this->sessionRepo->create($session);
        $createdSession = $createdSession->toArray();
        $this->assertArrayHasKey('id', $createdSession);
        $this->assertNotNull($createdSession['id'], 'Created Session must have id specified');
        $this->assertNotNull(Session::find($createdSession['id']), 'Session with given id must be in DB');
        $this->assertModelData($session, $createdSession);
    }

    /**
     * @test read
     */
    public function testReadSession()
    {
        $session = $this->makeSession();
        $dbSession = $this->sessionRepo->find($session->id);
        $dbSession = $dbSession->toArray();
        $this->assertModelData($session->toArray(), $dbSession);
    }

    /**
     * @test update
     */
    public function testUpdateSession()
    {
        $session = $this->makeSession();
        $fakeSession = $this->fakeSessionData();
        $updatedSession = $this->sessionRepo->update($fakeSession, $session->id);
        $this->assertModelData($fakeSession, $updatedSession->toArray());
        $dbSession = $this->sessionRepo->find($session->id);
        $this->assertModelData($fakeSession, $dbSession->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSession()
    {
        $session = $this->makeSession();
        $resp = $this->sessionRepo->delete($session->id);
        $this->assertTrue($resp);
        $this->assertNull(Session::find($session->id), 'Session should not exist in DB');
    }
}
