<?php

use App\Models\Parameters;
use App\Repositories\ParametersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParametersRepositoryTest extends TestCase
{
    use MakeParametersTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ParametersRepository
     */
    protected $parametersRepo;

    public function setUp()
    {
        parent::setUp();
        $this->parametersRepo = App::make(ParametersRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateParameters()
    {
        $parameters = $this->fakeParametersData();
        $createdParameters = $this->parametersRepo->create($parameters);
        $createdParameters = $createdParameters->toArray();
        $this->assertArrayHasKey('id', $createdParameters);
        $this->assertNotNull($createdParameters['id'], 'Created Parameters must have id specified');
        $this->assertNotNull(Parameters::find($createdParameters['id']), 'Parameters with given id must be in DB');
        $this->assertModelData($parameters, $createdParameters);
    }

    /**
     * @test read
     */
    public function testReadParameters()
    {
        $parameters = $this->makeParameters();
        $dbParameters = $this->parametersRepo->find($parameters->id);
        $dbParameters = $dbParameters->toArray();
        $this->assertModelData($parameters->toArray(), $dbParameters);
    }

    /**
     * @test update
     */
    public function testUpdateParameters()
    {
        $parameters = $this->makeParameters();
        $fakeParameters = $this->fakeParametersData();
        $updatedParameters = $this->parametersRepo->update($fakeParameters, $parameters->id);
        $this->assertModelData($fakeParameters, $updatedParameters->toArray());
        $dbParameters = $this->parametersRepo->find($parameters->id);
        $this->assertModelData($fakeParameters, $dbParameters->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteParameters()
    {
        $parameters = $this->makeParameters();
        $resp = $this->parametersRepo->delete($parameters->id);
        $this->assertTrue($resp);
        $this->assertNull(Parameters::find($parameters->id), 'Parameters should not exist in DB');
    }
}
