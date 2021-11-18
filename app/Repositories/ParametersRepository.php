<?php

namespace App\Repositories;

use App\Models\Parameters;

class ParametersRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'slug',
        'value'
    ];

    protected $modelClass = Parameters::class;
}
