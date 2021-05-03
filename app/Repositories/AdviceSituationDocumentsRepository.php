<?php

namespace App\Repositories;

use App\Models\AdviceSituationDocuments;
use InfyOm\Generator\Common\BaseRepository;

class AdviceSituationDocumentsRepository extends BaseRepository
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
        return AdviceSituationDocuments::class;
    }
}
