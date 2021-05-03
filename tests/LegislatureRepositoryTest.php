<?php

use App\Models\Legislature;
use App\Repositories\LegislatureRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LegislatureRepositoryTest extends TestCase
{
    use MakeLegislatureTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LegislatureRepository
     */
    protected $legislatureRepo;

    public function setUp()
    {
        parent::setUp();
        $this->legislatureRepo = App::make(LegislatureRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateLegislature()
    {
        $legislature = $this->fakeLegislatureData();
        $createdLegislature = $this->legislatureRepo->create($legislature);
        $createdLegislature = $createdLegislature->toArray();
        $this->assertArrayHasKey('id', $createdLegislature);
        $this->assertNotNull($createdLegislature['id'], 'Created Legislature must have id specified');
        $this->assertNotNull(Legislature::find($createdLegislature['id']), 'Legislature with given id must be in DB');
        $this->assertModelData($legislature, $createdLegislature);
    }

    /**
     * @test read
     */
    public function testReadLegislature()
    {
        $legislature = $this->makeLegislature();
        $dbLegislature = $this->legislatureRepo->find($legislature->id);
        $dbLegislature = $dbLegislature->toArray();
        $this->assertModelData($legislature->toArray(), $dbLegislature);
    }

    /**
     * @test update
     */
    public function testUpdateLegislature()
    {
        $legislature = $this->makeLegislature();
        $fakeLegislature = $this->fakeLegislatureData();
        $updatedLegislature = $this->legislatureRepo->update($fakeLegislature, $legislature->id);
        $this->assertModelData($fakeLegislature, $updatedLegislature->toArray());
        $dbLegislature = $this->legislatureRepo->find($legislature->id);
        $this->assertModelData($fakeLegislature, $dbLegislature->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteLegislature()
    {
        $legislature = $this->makeLegislature();
        $resp = $this->legislatureRepo->delete($legislature->id);
        $this->assertTrue($resp);
        $this->assertNull(Legislature::find($legislature->id), 'Legislature should not exist in DB');
    }
}
