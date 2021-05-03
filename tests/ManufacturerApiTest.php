<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManufacturerApiTest extends TestCase
{
    use MakeManufacturerTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateManufacturer()
    {
        $manufacturer = $this->fakeManufacturerData();
        $this->json('POST', '/api/v1/manufacturers', $manufacturer);

        $this->assertApiResponse($manufacturer);
    }

    /**
     * @test
     */
    public function testReadManufacturer()
    {
        $manufacturer = $this->makeManufacturer();
        $this->json('GET', '/api/v1/manufacturers/'.$manufacturer->id);

        $this->assertApiResponse($manufacturer->toArray());
    }

    /**
     * @test
     */
    public function testUpdateManufacturer()
    {
        $manufacturer = $this->makeManufacturer();
        $editedManufacturer = $this->fakeManufacturerData();

        $this->json('PUT', '/api/v1/manufacturers/'.$manufacturer->id, $editedManufacturer);

        $this->assertApiResponse($editedManufacturer);
    }

    /**
     * @test
     */
    public function testDeleteManufacturer()
    {
        $manufacturer = $this->makeManufacturer();
        $this->json('DELETE', '/api/v1/manufacturers/'.$manufacturer->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/manufacturers/'.$manufacturer->id);

        $this->assertResponseStatus(404);
    }
}
