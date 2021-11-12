<?php

namespace App\Repositories;

use App\Models\Commission;

class CommissionRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date_start',
        'date_end',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Commission::class;
    }
}
