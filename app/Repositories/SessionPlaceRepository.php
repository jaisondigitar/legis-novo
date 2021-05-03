<?php

namespace App\Repositories;

use App\Models\SessionPlace;
use InfyOm\Generator\Common\BaseRepository;

class SessionPlaceRepository extends BaseRepository
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
        return SessionPlace::class;
    }
}
