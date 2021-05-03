<?php

use Faker\Factory as Faker;
use App\Models\Unit;
use App\Repositories\UnitRepository;

trait MakeUnitTrait
{
    /**
     * Create fake instance of Unit and save it in database
     *
     * @param array $unitFields
     * @return Unit
     */
    public function makeUnit($unitFields = [])
    {
        /** @var UnitRepository $unitRepo */
        $unitRepo = App::make(UnitRepository::class);
        $theme = $this->fakeUnitData($unitFields);
        return $unitRepo->create($theme);
    }

    /**
     * Get fake instance of Unit
     *
     * @param array $unitFields
     * @return Unit
     */
    public function fakeUnit($unitFields = [])
    {
        return new Unit($this->fakeUnitData($unitFields));
    }

    /**
     * Get fake data of Unit
     *
     * @param array $postFields
     * @return array
     */
    public function fakeUnitData($unitFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'company_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $unitFields);
    }
}
