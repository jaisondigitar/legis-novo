<?php

use Faker\Factory as Faker;
use App\Models\Manufacturer;
use App\Repositories\ManufacturerRepository;

trait MakeManufacturerTrait
{
    /**
     * Create fake instance of Manufacturer and save it in database
     *
     * @param array $manufacturerFields
     * @return Manufacturer
     */
    public function makeManufacturer($manufacturerFields = [])
    {
        /** @var ManufacturerRepository $manufacturerRepo */
        $manufacturerRepo = App::make(ManufacturerRepository::class);
        $theme = $this->fakeManufacturerData($manufacturerFields);
        return $manufacturerRepo->create($theme);
    }

    /**
     * Get fake instance of Manufacturer
     *
     * @param array $manufacturerFields
     * @return Manufacturer
     */
    public function fakeManufacturer($manufacturerFields = [])
    {
        return new Manufacturer($this->fakeManufacturerData($manufacturerFields));
    }

    /**
     * Get fake data of Manufacturer
     *
     * @param array $postFields
     * @return array
     */
    public function fakeManufacturerData($manufacturerFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'company_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'email' => $fake->word,
            'url' => $fake->word,
            'phone' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $manufacturerFields);
    }
}
