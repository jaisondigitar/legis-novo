<?php

namespace App\Repositories;

use App\Models\StatusProcessingDocument;

class StatusProcessingDocumentRepository
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
        return StatusProcessingDocument::class;
    }
}
