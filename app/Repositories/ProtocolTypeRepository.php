<?php

namespace App\Repositories;

use App\Models\ProtocolType;

class ProtocolTypeRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug'
    ];

    protected $modelClass = ProtocolType::class;
}
