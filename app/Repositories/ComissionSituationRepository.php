<?php

namespace App\Repositories;

use App\Models\ComissionSituation;

class ComissionSituationRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    protected $modelClass = ComissionSituation::class;
}
