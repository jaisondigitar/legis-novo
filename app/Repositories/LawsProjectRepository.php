<?php

namespace App\Repositories;

use App\Models\LawsProject;

class LawsProjectRepository extends Repository
{
    protected $modelClass = LawsProject::class;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'law_type_id',
        'law_place_id',
        'law_number',
        'title'
    ];
}
