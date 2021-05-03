<?php

namespace App\Repositories;

use App\Models\AdvicePublicationDocuments;
use InfyOm\Generator\Common\BaseRepository;

class AdvicePublicationDocumentsRepository extends BaseRepository
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
