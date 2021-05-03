<?php

use Faker\Factory as Faker;
use App\Models\ProtocolType;
use App\Repositories\ProtocolTypeRepository;

trait MakeProtocolTypeTrait
{
    /**
     * Create fake instance of ProtocolType and save it in database
     *
     * @param array $protocolTypeFields
     * @return ProtocolType
     */
    public function makeProtocolType($protocolTypeFields = [])
    {
        /** @var ProtocolTypeRepository $protocolTypeRepo */
        $protocolTypeRepo = App::make(ProtocolTypeRepository::class);
        $theme = $this->fakeProtocolTypeData($protocolTypeFields);
        return $protocolTypeRepo->create($theme);
    }

    /**
     * Get fake instance of ProtocolType
     *
     * @param array $protocolTypeFields
     * @return ProtocolType
     */
    public function fakeProtocolType($protocolTypeFields = [])
    {
        return new ProtocolType($this->fakeProtocolTypeData($protocolTypeFields));
    }

    /**
     * Get fake data of ProtocolType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProtocolTypeData($protocolTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $protocolTypeFields);
    }
}
