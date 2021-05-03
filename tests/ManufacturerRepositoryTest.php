<?php

use App\Models\Manufacturer;
use App\Repositories\ManufacturerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManufacturerRepositoryTest extends TestCase
{
    use MakeManufacturerTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ManufacturerRepository
     */
    protected $manufacturerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->manufacturerRepo = App::make(ManufacturerRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateManufacturer()
    {
        $manufacturer = $this->fakeManufacturerData();
        $createdManufacturer = $this->manufacturerRepo->create($manufacturer);
        $createdManufacturer = $createdManufacturer->toArray();
        $this->assertArrayHasKey('id', $createdManufacturer);
        $this->assertNotNull($createdManufacturer['id'], 'Created Manufacturer must have id specified');
        $this->assertNotNull(Manufacturer::find($createdManufacturer['id']), 'Manufacturer with given id must be in DB');
        $this->assertModelData($manufacturer, $createdManufacturer);
    }

    /**
     * @test read
     */
    public function testReadManufacturer()
    {
        $manufacturer = $this->makeManufacturer();
        $dbManufacturer = $this->manufacturerRepo->find($manufacturer->id);
        $dbManufacturer = $dbManufacturer->toArray();
        $this->assertModelData($manufacturer->toArray(), $dbManufacturer);
    }

    /**
     * @test update
     */
    public function testUpdateManufacturer()
    {
        $manufacturer = $this->makeManufacturer();
        $fakeManufacturer = $this->fakeManufacturerData();
        $updatedManufacturer = $this->manufacturerRepo->update($fakeManufacturer, $manufacturer->id);
        $this->assertModelData($fakeManufacturer, $updatedManufacturer->toArray());
        $dbManufacturer = $this->manufacturerRepo->find($manufacturer->id);
        $this->assertModelData($fakeManufacturer, $dbManufacturer->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteManufacturer()
    {
        $manufacturer = $this->makeManufacturer();
        $resp = $this->manufacturerRepo->delete($manufacturer->id);
        $this->assertTrue($resp);
        $this->assertNull(Manufacturer::find($manufacturer->id), 'Manufacturer should not exist in DB');
    }
}
