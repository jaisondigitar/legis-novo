<?php

namespace App\Repositories;

use App\Models\ProtocolType;

class ProtocolTypeRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProtocolType::class;
    }
}
