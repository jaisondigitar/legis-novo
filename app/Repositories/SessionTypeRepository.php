<?php

namespace App\Repositories;

use App\Models\SessionType;

class SessionTypeRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelClass = SessionType::class;
}
