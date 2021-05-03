<?php

use Faker\Factory as Faker;
use App\Models\OfficeCommission;
use App\Repositories\OfficeCommissionRepository;

trait MakeOfficeCommissionTrait
{
    /**
     * Create fake instance of OfficeCommission and save it in database
     *
     * @param array $officeCommissionFields
     * @return OfficeCommission
     */
    public function makeOfficeCommission($officeCommissionFields = [])
    {
        /** @var OfficeCommissionRepository $officeCommissionRepo */
        $officeCommissionRepo = App::make(OfficeCommissionRepository::class);
        $theme = $this->fakeOfficeCommissionData($officeCommissionFields);
        return $officeCommissionRepo->create($theme);
    }

    /**
     * Get fake instance of OfficeCommission
     *
     * @param array $officeCommissionFields
     * @return OfficeCommission
     */
    public function fakeOfficeCommission($officeCommissionFields = [])
    {
        return new OfficeCommission($this->fakeOfficeCommissionData($officeCommissionFields));
    }

    /**
     * Get fake data of OfficeCommission
     *
     * @param array $postFields
     * @return array
     */
    public function fakeOfficeCommissionData($officeCommissionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'id' => $fake->word,
            'name' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $officeCommissionFields);
    }
}
