<?php

use Faker\Factory as Faker;
use App\Models\ResponsibilityAssemblyman;
use App\Repositories\ResponsibilityAssemblymanRepository;

trait MakeResponsibilityAssemblymanTrait
{
    /**
     * Create fake instance of ResponsibilityAssemblyman and save it in database
     *
     * @param array $responsibilityAssemblymanFields
     * @return ResponsibilityAssemblyman
     */
    public function makeResponsibilityAssemblyman($responsibilityAssemblymanFields = [])
    {
        /** @var ResponsibilityAssemblymanRepository $responsibilityAssemblymanRepo */
        $responsibilityAssemblymanRepo = App::make(ResponsibilityAssemblymanRepository::class);
        $theme = $this->fakeResponsibilityAssemblymanData($responsibilityAssemblymanFields);
        return $responsibilityAssemblymanRepo->create($theme);
    }

    /**
     * Get fake instance of ResponsibilityAssemblyman
     *
     * @param array $responsibilityAssemblymanFields
     * @return ResponsibilityAssemblyman
     */
    public function fakeResponsibilityAssemblyman($responsibilityAssemblymanFields = [])
    {
        return new ResponsibilityAssemblyman($this->fakeResponsibilityAssemblymanData($responsibilityAssemblymanFields));
    }

    /**
     * Get fake data of ResponsibilityAssemblyman
     *
     * @param array $postFields
     * @return array
     */
    public function fakeResponsibilityAssemblymanData($responsibilityAssemblymanFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'responsibility_id' => $fake->randomDigitNotNull,
            'assemblyman_id' => $fake->randomDigitNotNull,
            'date' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $responsibilityAssemblymanFields);
    }
}
