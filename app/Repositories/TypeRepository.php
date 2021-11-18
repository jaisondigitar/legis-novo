<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'prefix',
        'name',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Type::class;
    }
}
