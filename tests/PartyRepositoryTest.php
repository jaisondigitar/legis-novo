<?php

use App\Models\Party;
use App\Repositories\PartyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PartyRepositoryTest extends TestCase
{
    use MakePartyTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PartyRepository
     */
    protected $partyRepo;

    public function setUp()
    {
        parent::setUp();
        $this->partyRepo = App::make(PartyRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateParty()
    {
        $party = $this->fakePartyData();
        $createdParty = $this->partyRepo->create($party);
        $createdParty = $createdParty->toArray();
        $this->assertArrayHasKey('id', $createdParty);
        $this->assertNotNull($createdParty['id'], 'Created Party must have id specified');
        $this->assertNotNull(Party::find($createdParty['id']), 'Party with given id must be in DB');
        $this->assertModelData($party, $createdParty);
    }

    /**
     * @test read
     */
    public function testReadParty()
    {
        $party = $this->makeParty();
        $dbParty = $this->partyRepo->find($party->id);
        $dbParty = $dbParty->toArray();
        $this->assertModelData($party->toArray(), $dbParty);
    }

    /**
     * @test update
     */
    public function testUpdateParty()
    {
        $party = $this->makeParty();
        $fakeParty = $this->fakePartyData();
        $updatedParty = $this->partyRepo->update($fakeParty, $party->id);
        $this->assertModelData($fakeParty, $updatedParty->toArray());
        $dbParty = $this->partyRepo->find($party->id);
        $this->assertModelData($fakeParty, $dbParty->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteParty()
    {
        $party = $this->makeParty();
        $resp = $this->partyRepo->delete($party->id);
        $this->assertTrue($resp);
        $this->assertNull(Party::find($party->id), 'Party should not exist in DB');
    }
}
