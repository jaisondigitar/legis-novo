<?php

namespace App\Repositories;

use App\Models\DocumentModels;
use InfyOm\Generator\Common\BaseRepository;

class DocumentModelsRepository extends BaseRepository
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
