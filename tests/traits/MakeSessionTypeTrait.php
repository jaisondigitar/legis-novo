<?php

use Faker\Factory as Faker;
use App\Models\SessionType;
use App\Repositories\SessionTypeRepository;

trait MakeSessionTypeTrait
{
    /**
     * Create fake instance of SessionType and save it in database
     *
     * @param array $sessionTypeFields
     * @return SessionType
     */
    public function makeSessionType($sessionTypeFields = [])
    {
        /** @var SessionTypeRepository $sessionTypeRepo */
        $sessionTypeRepo = App::make(SessionTypeRepository::class);
        $theme = $this->fakeSessionTypeData($sessionTypeFields);
        return $sessionTypeRepo->create($theme);
    }

    /**
     * Get fake instance of SessionType
     *
     * @param array $sessionTypeFields
     * @return SessionType
     */
    public function fakeSessionType($sessionTypeFields = [])
    {
        return new SessionType($this->fakeSessionTypeData($sessionTypeFields));
    }

    /**
     * Get fake data of SessionType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSessionTypeData($sessionTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $sessionTypeFields);
    }
}
