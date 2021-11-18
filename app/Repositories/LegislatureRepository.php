<?php

namespace App\Repositories;

use App\Models\Legislature;

class LegislatureRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'from',
        'to',
    ];

    protected $modelClass = Legislature::class;
}
