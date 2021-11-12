<?php

namespace App\Repositories;

use App\Models\OfficeCommission;

class OfficeCommissionRepository
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
        return OfficeCommission::class;
    }
}
