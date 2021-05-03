<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConfigApiTest extends TestCase
{
    use MakeConfigTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateConfig()
    {
        $config = $this->fakeConfigData();
        $this->json('POST', '/api/v1/configs', $config);

        $this->assertApiResponse($config);
    }

    /**
     * @test
     */
    public function testReadConfig()
    {
        $config = $this->makeConfig();
        $this->json('GET', '/api/v1/configs/'.$config->id);

        $this->assertApiResponse($config->toArray());
    }

    /**
     * @test
     */
    public function testUpdateConfig()
    {
        $config = $this->makeConfig();
        $editedConfig = $this->fakeConfigData();

        $this->json('PUT', '/api/v1/configs/'.$config->id, $editedConfig);

        $this->assertApiResponse($editedConfig);
    }

    /**
     * @test
     */
    public function testDeleteConfig()
    {
        $config = $this->makeConfig();
        $this->json('DELETE', '/api/v1/configs/'.$config->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/configs/'.$config->id);

        $this->assertResponseStatus(404);
    }
}
