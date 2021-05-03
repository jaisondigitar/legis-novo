<?php

use App\Models\Config;
use App\Repositories\ConfigRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConfigRepositoryTest extends TestCase
{
    use MakeConfigTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ConfigRepository
     */
    protected $configRepo;

    public function setUp()
    {
        parent::setUp();
        $this->configRepo = App::make(ConfigRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateConfig()
    {
        $config = $this->fakeConfigData();
        $createdConfig = $this->configRepo->create($config);
        $createdConfig = $createdConfig->toArray();
        $this->assertArrayHasKey('id', $createdConfig);
        $this->assertNotNull($createdConfig['id'], 'Created Config must have id specified');
        $this->assertNotNull(Config::find($createdConfig['id']), 'Config with given id must be in DB');
        $this->assertModelData($config, $createdConfig);
    }

    /**
     * @test read
     */
    public function testReadConfig()
    {
        $config = $this->makeConfig();
        $dbConfig = $this->configRepo->find($config->id);
        $dbConfig = $dbConfig->toArray();
        $this->assertModelData($config->toArray(), $dbConfig);
    }

    /**
     * @test update
     */
    public function testUpdateConfig()
    {
        $config = $this->makeConfig();
        $fakeConfig = $this->fakeConfigData();
        $updatedConfig = $this->configRepo->update($fakeConfig, $config->id);
        $this->assertModelData($fakeConfig, $updatedConfig->toArray());
        $dbConfig = $this->configRepo->find($config->id);
        $this->assertModelData($fakeConfig, $dbConfig->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteConfig()
    {
        $config = $this->makeConfig();
        $resp = $this->configRepo->delete($config->id);
        $this->assertTrue($resp);
        $this->assertNull(Config::find($config->id), 'Config should not exist in DB');
    }
}
