<?php

use Faker\Factory as Faker;
use App\Models\PartiesAssemblyman;
use App\Repositories\PartiesAssemblymanRepository;

trait MakePartiesAssemblymanTrait
{
    /**
     * Create fake instance of PartiesAssemblyman and save it in database
     *
     * @param array $partiesAssemblymanFields
     * @return PartiesAssemblyman
     */
    public function makePartiesAssemblyman($partiesAssemblymanFields = [])
    {
        /** @var PartiesAssemblymanRepository $partiesAssemblymanRepo */
        $partiesAssemblymanRepo = App::make(PartiesAssemblymanRepository::class);
        $theme = $this->fakePartiesAssemblymanData($partiesAssemblymanFields);
        return $partiesAssemblymanRepo->create($theme);
    }

    /**
     * Get fake instance of PartiesAssemblyman
     *
     * @param array $partiesAssemblymanFields
     * @return PartiesAssemblyman
     */
    public function fakePartiesAssemblyman($partiesAssemblymanFields = [])
    {
        return new PartiesAssemblyman($this->fakePartiesAssemblymanData($partiesAssemblymanFields));
    }

    /**
     * Get fake data of PartiesAssemblyman
     *
     * @param array $postFields
     * @return array
     */
    public function fakePartiesAssemblymanData($partiesAssemblymanFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'party_id' => $fake->randomDigitNotNull,
            'assemblyman_id' => $fake->randomDigitNotNull,
            'date' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $partiesAssemblymanFields);
    }
}
