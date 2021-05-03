<?php

use Faker\Factory as Faker;
use App\Models\SessionPlace;
use App\Repositories\SessionPlaceRepository;

trait MakeSessionPlaceTrait
{
    /**
     * Create fake instance of SessionPlace and save it in database
     *
     * @param array $sessionPlaceFields
     * @return SessionPlace
     */
    public function makeSessionPlace($sessionPlaceFields = [])
    {
        /** @var SessionPlaceRepository $sessionPlaceRepo */
        $sessionPlaceRepo = App::make(SessionPlaceRepository::class);
        $theme = $this->fakeSessionPlaceData($sessionPlaceFields);
        return $sessionPlaceRepo->create($theme);
    }

    /**
     * Get fake instance of SessionPlace
     *
     * @param array $sessionPlaceFields
     * @return SessionPlace
     */
    public function fakeSessionPlace($sessionPlaceFields = [])
    {
        return new SessionPlace($this->fakeSessionPlaceData($sessionPlaceFields));
    }

    /**
     * Get fake data of SessionPlace
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSessionPlaceData($sessionPlaceFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $sessionPlaceFields);
    }
}
