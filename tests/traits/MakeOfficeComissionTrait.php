<?php

use Faker\Factory as Faker;
use App\Models\OfficeComission;
use App\Repositories\OfficeComissionRepository;

trait MakeOfficeComissionTrait
{
    /**
     * Create fake instance of OfficeComission and save it in database
     *
     * @param array $officeComissionFields
     * @return OfficeComission
     */
    public function makeOfficeComission($officeComissionFields = [])
    {
        /** @var OfficeComissionRepository $officeComissionRepo */
        $officeComissionRepo = App::make(OfficeComissionRepository::class);
        $theme = $this->fakeOfficeComissionData($officeComissionFields);
        return $officeComissionRepo->create($theme);
    }

    /**
     * Get fake instance of OfficeComission
     *
     * @param array $officeComissionFields
     * @return OfficeComission
     */
    public function fakeOfficeComission($officeComissionFields = [])
    {
        return new OfficeComission($this->fakeOfficeComissionData($officeComissionFields));
    }

    /**
     * Get fake data of OfficeComission
     *
     * @param array $postFields
     * @return array
     */
    public function fakeOfficeComissionData($officeComissionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'id' => $fake->word,
            'name' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $officeComissionFields);
    }
}
