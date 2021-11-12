<?php

namespace App\Repositories;

use App\Models\StatusProcessingLaw;

class StatusProcessingLawRepository
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
        return StatusProcessingLaw::class;
    }
}
