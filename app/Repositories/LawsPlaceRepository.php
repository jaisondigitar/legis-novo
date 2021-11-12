<?php

namespace App\Repositories;

use App\Models\LawsPlace;

class LawsPlaceRepository
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
        return LawsPlace::class;
    }
}
