<?php

use Faker\Factory as Faker;
use App\Models\Responsibility;
use App\Repositories\ResponsibilityRepository;

trait MakeResponsibilityTrait
{
    /**
     * Create fake instance of Responsibility and save it in database
     *
     * @param array $responsibilityFields
     * @return Responsibility
     */
    public function makeResponsibility($responsibilityFields = [])
    {
        /** @var ResponsibilityRepository $responsibilityRepo */
        $responsibilityRepo = App::make(ResponsibilityRepository::class);
        $theme = $this->fakeResponsibilityData($responsibilityFields);
        return $responsibilityRepo->create($theme);
    }

    /**
     * Get fake instance of Responsibility
     *
     * @param array $responsibilityFields
     * @return Responsibility
     */
    public function fakeResponsibility($responsibilityFields = [])
    {
        return new Responsibility($this->fakeResponsibilityData($responsibilityFields));
    }

    /**
     * Get fake data of Responsibility
     *
     * @param array $postFields
     * @return array
     */
    public function fakeResponsibilityData($responsibilityFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'companies_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $responsibilityFields);
    }
}
