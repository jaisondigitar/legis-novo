<?php

use Faker\Factory as Faker;
use App\Models\Sector;
use App\Repositories\SectorRepository;

trait MakeSectorTrait
{
    /**
     * Create fake instance of Sector and save it in database
     *
     * @param array $sectorFields
     * @return Sector
     */
    public function makeSector($sectorFields = [])
    {
        /** @var SectorRepository $sectorRepo */
        $sectorRepo = App::make(SectorRepository::class);
        $theme = $this->fakeSectorData($sectorFields);
        return $sectorRepo->create($theme);
    }

    /**
     * Get fake instance of Sector
     *
     * @param array $sectorFields
     * @return Sector
     */
    public function fakeSector($sectorFields = [])
    {
        return new Sector($this->fakeSectorData($sectorFields));
    }

    /**
     * Get fake data of Sector
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSectorData($sectorFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $sectorFields);
    }
}
