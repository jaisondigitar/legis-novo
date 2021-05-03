<?php

use Faker\Factory as Faker;
use App\Models\Assemblyman;
use App\Repositories\AssemblymanRepository;

trait MakeAssemblymanTrait
{
    /**
     * Create fake instance of Assemblyman and save it in database
     *
     * @param array $assemblymanFields
     * @return Assemblyman
     */
    public function makeAssemblyman($assemblymanFields = [])
    {
        /** @var AssemblymanRepository $assemblymanRepo */
        $assemblymanRepo = App::make(AssemblymanRepository::class);
        $theme = $this->fakeAssemblymanData($assemblymanFields);
        return $assemblymanRepo->create($theme);
    }

    /**
     * Get fake instance of Assemblyman
     *
     * @param array $assemblymanFields
     * @return Assemblyman
     */
    public function fakeAssemblyman($assemblymanFields = [])
    {
        return new Assemblyman($this->fakeAssemblymanData($assemblymanFields));
    }

    /**
     * Get fake data of Assemblyman
     *
     * @param array $postFields
     * @return array
     */
    public function fakeAssemblymanData($assemblymanFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'companies_id' => $fake->randomDigitNotNull,
            'image' => $fake->word,
            'short_name' => $fake->word,
            'full_name' => $fake->word,
            'email' => $fake->word,
            'phone1' => $fake->word,
            'phone2' => $fake->word,
            'official_document' => $fake->word,
            'general_register' => $fake->word,
            'street' => $fake->word,
            'number' => $fake->word,
            'complement' => $fake->word,
            'district' => $fake->word,
            'state_id' => $fake->randomDigitNotNull,
            'city_id' => $fake->randomDigitNotNull,
            'zipcode' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $assemblymanFields);
    }
}
