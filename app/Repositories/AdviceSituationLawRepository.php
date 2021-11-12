<?php

namespace App\Repositories;

use App\Models\AdviceSituationLaw;

class AdviceSituationLawRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdviceSituationLaw::class;
    }
}
