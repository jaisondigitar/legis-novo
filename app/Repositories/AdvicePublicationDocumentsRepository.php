<?php

namespace App\Repositories;

use App\Models\AdvicePublicationDocuments;

class AdvicePublicationDocumentsRepository
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
        return AdvicePublicationDocuments::class;
    }
}
