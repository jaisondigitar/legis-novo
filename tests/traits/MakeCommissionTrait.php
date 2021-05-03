<?php

use Faker\Factory as Faker;
use App\Models\Commission;
use App\Repositories\CommissionRepository;

trait MakeCommissionTrait
{
    /**
     * Create fake instance of Commission and save it in database
     *
     * @param array $commissionFields
     * @return Commission
     */
    public function makeCommission($commissionFields = [])
    {
        /** @var CommissionRepository $commissionRepo */
        $commissionRepo = App::make(CommissionRepository::class);
        $theme = $this->fakeCommissionData($commissionFields);
        return $commissionRepo->create($theme);
    }

    /**
     * Get fake instance of Commission
     *
     * @param array $commissionFields
     * @return Commission
     */
    public function fakeCommission($commissionFields = [])
    {
        return new Commission($this->fakeCommissionData($commissionFields));
    }

    /**
     * Get fake data of Commission
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCommissionData($commissionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'date_start' => $fake->word,
            'date_end' => $fake->word,
            'name' => $fake->word,
            'description' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $commissionFields);
    }
}
