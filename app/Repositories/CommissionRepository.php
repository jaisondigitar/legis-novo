<?php

namespace App\Repositories;

use App\Models\Commission;

class CommissionRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date_start',
        'date_end',
        'name'
    ];

    protected $modelClass = Commission::class;
}
