<?php

namespace App\Repositories;

use App\Models\LawsTag;

class LawsTagRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelClass = LawsTag::class;
}
