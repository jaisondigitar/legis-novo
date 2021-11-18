<?php

namespace App\Repositories;

use App\Models\Responsibility;

class ResponsibilityRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'name'
    ];

    protected $modelClass = Responsibility::class;
}
