<?php

namespace App\Repositories;

use App\Models\Responsibility;

class ResponsibilityRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Responsibility::class;
    }
}
