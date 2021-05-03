<?php

namespace App\Repositories;

use App\Models\AdvicePublicationLaw;
use InfyOm\Generator\Common\BaseRepository;

class AdvicePublicationLawRepository extends BaseRepository
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
        return AdvicePublicationLaw::class;
    }
}
