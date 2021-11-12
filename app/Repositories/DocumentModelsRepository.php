<?php

namespace App\Repositories;

use App\Models\DocumentModels;

class DocumentModelsRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'document_type_id',
        'name',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DocumentModels::class;
    }
}
