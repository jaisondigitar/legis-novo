<?php

use Faker\Factory as Faker;
use App\Models\Config;
use App\Repositories\ConfigRepository;

trait MakeConfigTrait
{
    /**
     * Create fake instance of Config and save it in database
     *
     * @param array $configFields
     * @return Config
     */
    public function makeConfig($configFields = [])
    {
        /** @var ConfigRepository $configRepo */
        $configRepo = App::make(ConfigRepository::class);
        $theme = $this->fakeConfigData($configFields);
        return $configRepo->create($theme);
    }

    /**
     * Get fake instance of Config
     *
     * @param array $configFields
     * @return Config
     */
    public function fakeConfig($configFields = [])
    {
        return new Config($this->fakeConfigData($configFields));
    }

    /**
     * Get fake data of Config
     *
     * @param array $postFields
     * @return array
     */
    public function fakeConfigData($configFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'type' => $fake->randomDigitNotNull,
            'slug' => $fake->word,
            'value' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $configFields);
    }
}
