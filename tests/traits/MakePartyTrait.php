<?php

use Faker\Factory as Faker;
use App\Models\Party;
use App\Repositories\PartyRepository;

trait MakePartyTrait
{
    /**
     * Create fake instance of Party and save it in database
     *
     * @param array $partyFields
     * @return Party
     */
    public function makeParty($partyFields = [])
    {
        /** @var PartyRepository $partyRepo */
        $partyRepo = App::make(PartyRepository::class);
        $theme = $this->fakePartyData($partyFields);
        return $partyRepo->create($theme);
    }

    /**
     * Get fake instance of Party
     *
     * @param array $partyFields
     * @return Party
     */
    public function fakeParty($partyFields = [])
    {
        return new Party($this->fakePartyData($partyFields));
    }

    /**
     * Get fake data of Party
     *
     * @param array $postFields
     * @return array
     */
    public function fakePartyData($partyFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'companies_id' => $fake->randomDigitNotNull,
            'prefix' => $fake->word,
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $partyFields);
    }
}
