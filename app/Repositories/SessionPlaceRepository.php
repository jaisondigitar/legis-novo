<?php

namespace App\Repositories;

use App\Models\SessionPlace;

class SessionPlaceRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return SessionPlace::class;
    }
}
