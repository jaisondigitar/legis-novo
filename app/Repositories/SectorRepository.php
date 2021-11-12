<?php

namespace App\Repositories;

use App\Models\Sector;

class SectorRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sector::class;
    }
}
