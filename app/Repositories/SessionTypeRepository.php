<?php

namespace App\Repositories;

use App\Models\SessionType;
use InfyOm\Generator\Common\BaseRepository;

class SessionTypeRepository extends BaseRepository
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
