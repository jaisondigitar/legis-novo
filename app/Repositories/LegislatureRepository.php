<?php

namespace App\Repositories;

use App\Models\Legislature;

class LegislatureRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'from',
        'to'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Legislature::class;
    }
}
