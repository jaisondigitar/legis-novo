<?php

namespace App\Repositories;

use App\Models\DocumentSituation;

class DocumentSituationRepository
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
        return DocumentSituation::class;
    }
}
