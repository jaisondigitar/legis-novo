<?php

namespace App\Repositories;

use App\Models\Document;

class DocumentRepository extends Repository
{
    protected $modelClass = Document::class;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'document_type_id',
        'user_id',
        'owner_id',
        'number',
        'content',
        'session_date',
        'read',
        'approved'
    ];
}
