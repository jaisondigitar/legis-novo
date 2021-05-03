<?php

use Faker\Factory as Faker;
use App\Models\Legislature;
use App\Repositories\LegislatureRepository;

trait MakeLegislatureTrait
{
    /**
     * Create fake instance of Legislature and save it in database
     *
     * @param array $legislatureFields
     * @return Legislature
     */
    public function makeLegislature($legislatureFields = [])
    {
        /** @var LegislatureRepository $legislatureRepo */
        $legislatureRepo = App::make(LegislatureRepository::class);
        $theme = $this->fakeLegislatureData($legislatureFields);
        return $legislatureRepo->create($theme);
    }

    /**
     * Get fake instance of Legislature
     *
     * @param array $legislatureFields
     * @return Legislature
     */
    public function fakeLegislature($legislatureFields = [])
    {
        return new Legislature($this->fakeLegislatureData($legislatureFields));
    }

    /**
     * Get fake data of Legislature
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLegislatureData($legislatureFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'companies_id' => $fake->randomDigitNotNull,
            'from' => $fake->word,
            'to' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $legislatureFields);
    }
}
