<?php

namespace App\Repositories;

use App\Models\StatusProcessingDocument;
use InfyOm\Generator\Common\BaseRepository;

class StatusProcessingDocumentRepository extends BaseRepository
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
