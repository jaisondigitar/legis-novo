<?php

namespace App\Repositories;

use App\Models\OfficeCommission;

class OfficeCommissionRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
    ];

    protected $modelClass = OfficeCommission::class;
}
