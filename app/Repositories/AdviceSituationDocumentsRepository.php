<?php

namespace App\Repositories;

use App\Models\AdviceSituationDocuments;

class AdviceSituationDocumentsRepository
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
        return AdviceSituationDocuments::class;
    }
}
