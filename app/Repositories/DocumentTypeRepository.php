<?php

namespace App\Repositories;

use App\Models\DocumentType;

class DocumentTypeRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'prefix',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DocumentType::class;
    }
}
