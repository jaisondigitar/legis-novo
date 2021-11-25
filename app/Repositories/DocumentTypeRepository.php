<?php

namespace App\Repositories;

use App\Models\DocumentType;

class DocumentTypeRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'prefix',
        'slug',
    ];

    protected $modelClass = DocumentType::class;
}
