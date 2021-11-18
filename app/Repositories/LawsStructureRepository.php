<?php

namespace App\Repositories;

use App\Models\LawsStructure;

class LawsStructureRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    protected $modelClass = LawsStructure::class;
}
