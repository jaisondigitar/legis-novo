<?php

namespace App\Repositories;

use App\Models\ComissionSituation;

class ComissionSituationRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ComissionSituation::class;
    }
}
