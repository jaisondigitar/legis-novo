<?php

use Faker\Factory as Faker;
use App\Models\Meeting;
use App\Repositories\MeetingRepository;

trait MakeMeetingTrait
{
    /**
     * Create fake instance of Meeting and save it in database
     *
     * @param array $meetingFields
     * @return Meeting
     */
    public function makeMeeting($meetingFields = [])
    {
        /** @var MeetingRepository $meetingRepo */
        $meetingRepo = App::make(MeetingRepository::class);
        $theme = $this->fakeMeetingData($meetingFields);
        return $meetingRepo->create($theme);
    }

    /**
     * Get fake instance of Meeting
     *
     * @param array $meetingFields
     * @return Meeting
     */
    public function fakeMeeting($meetingFields = [])
    {
        return new Meeting($this->fakeMeetingData($meetingFields));
    }

    /**
     * Get fake data of Meeting
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMeetingData($meetingFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'session_type_id' => $fake->randomDigitNotNull,
            'session_place_id' => $fake->randomDigitNotNull,
            'date_start' => $fake->date('Y-m-d H:i:s'),
            'date_end' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $meetingFields);
    }
}
