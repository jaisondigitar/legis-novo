<?php

use Faker\Factory as Faker;
use App\Models\Session;
use App\Repositories\SessionRepository;

trait MakeSessionTrait
{
    /**
     * Create fake instance of Session and save it in database
     *
     * @param array $sessionFields
     * @return Session
     */
    public function makeSession($sessionFields = [])
    {
        /** @var SessionRepository $sessionRepo */
        $sessionRepo = App::make(SessionRepository::class);
        $theme = $this->fakeSessionData($sessionFields);
        return $sessionRepo->create($theme);
    }

    /**
     * Get fake instance of Session
     *
     * @param array $sessionFields
     * @return Session
     */
    public function fakeSession($sessionFields = [])
    {
        return new Session($this->fakeSessionData($sessionFields));
    }

    /**
     * Get fake data of Session
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSessionData($sessionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'session_type_id' => $fake->randomDigitNotNull,
            'session_place_id' => $fake->randomDigitNotNull,
            'number' => $fake->word,
            'date_start' => $fake->date('Y-m-d H:i:s'),
            'date_end' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $sessionFields);
    }
}
