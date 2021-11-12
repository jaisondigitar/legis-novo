<?php

namespace App\Repositories;

use App\Models\SessionType;

class SessionTypeRepository
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
        return SessionType::class;
    }
}
