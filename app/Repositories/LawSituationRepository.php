<?php

namespace App\Repositories;

use App\Models\LawSituation;

class LawSituationRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    protected $modelClass = LawSituation::class;
}
