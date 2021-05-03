<?php

use Faker\Factory as Faker;
use App\Models\Parameters;
use App\Repositories\ParametersRepository;

trait MakeParametersTrait
{
    /**
     * Create fake instance of Parameters and save it in database
     *
     * @param array $parametersFields
     * @return Parameters
     */
    public function makeParameters($parametersFields = [])
    {
        /** @var ParametersRepository $parametersRepo */
        $parametersRepo = App::make(ParametersRepository::class);
        $theme = $this->fakeParametersData($parametersFields);
        return $parametersRepo->create($theme);
    }

    /**
     * Get fake instance of Parameters
     *
     * @param array $parametersFields
     * @return Parameters
     */
    public function fakeParameters($parametersFields = [])
    {
        return new Parameters($this->fakeParametersData($parametersFields));
    }

    /**
     * Get fake data of Parameters
     *
     * @param array $postFields
     * @return array
     */
    public function fakeParametersData($parametersFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'type' => $fake->randomDigitNotNull,
            'slug' => $fake->word,
            'value' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $parametersFields);
    }
}
