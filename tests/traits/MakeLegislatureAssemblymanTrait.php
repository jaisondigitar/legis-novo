<?php

use Faker\Factory as Faker;
use App\Models\LegislatureAssemblyman;
use App\Repositories\LegislatureAssemblymanRepository;

trait MakeLegislatureAssemblymanTrait
{
    /**
     * Create fake instance of LegislatureAssemblyman and save it in database
     *
     * @param array $legislatureAssemblymanFields
     * @return LegislatureAssemblyman
     */
    public function makeLegislatureAssemblyman($legislatureAssemblymanFields = [])
    {
        /** @var LegislatureAssemblymanRepository $legislatureAssemblymanRepo */
        $legislatureAssemblymanRepo = App::make(LegislatureAssemblymanRepository::class);
        $theme = $this->fakeLegislatureAssemblymanData($legislatureAssemblymanFields);
        return $legislatureAssemblymanRepo->create($theme);
    }

    /**
     * Get fake instance of LegislatureAssemblyman
     *
     * @param array $legislatureAssemblymanFields
     * @return LegislatureAssemblyman
     */
    public function fakeLegislatureAssemblyman($legislatureAssemblymanFields = [])
    {
        return new LegislatureAssemblyman($this->fakeLegislatureAssemblymanData($legislatureAssemblymanFields));
    }

    /**
     * Get fake data of LegislatureAssemblyman
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLegislatureAssemblymanData($legislatureAssemblymanFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'legislature_id' => $fake->randomDigitNotNull,
            'assemblyman_id' => $fake->randomDigitNotNull
        ], $legislatureAssemblymanFields);
    }
}
