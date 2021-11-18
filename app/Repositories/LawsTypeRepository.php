<?php

namespace App\Repositories;

use App\Models\LawsType;

class LawsTypeRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelClass = LawsType::class;
}
