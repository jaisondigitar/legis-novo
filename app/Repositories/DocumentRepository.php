<?php

namespace App\Repositories;

use App\Models\Document;
use InfyOm\Generator\Common\BaseRepository;

class DocumentRepository extends BaseRepository
{
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

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Document::class;
    }
}
