<?php

namespace App\Repositories;

use App\Models\LawsPlace;

class LawsPlaceRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    protected $modelClass = LawsPlace::class;
}
