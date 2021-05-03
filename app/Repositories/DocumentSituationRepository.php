<?php

namespace App\Repositories;

use App\Models\DocumentSituation;
use InfyOm\Generator\Common\BaseRepository;

class DocumentSituationRepository extends BaseRepository
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
