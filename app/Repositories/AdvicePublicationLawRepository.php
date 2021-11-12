<?php

namespace App\Repositories;

use App\Models\AdvicePublicationLaw;

class AdvicePublicationLawRepository
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
        return AdvicePublicationLaw::class;
    }
}
