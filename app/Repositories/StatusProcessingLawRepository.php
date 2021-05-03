<?php

namespace App\Repositories;

use App\Models\StatusProcessingLaw;
use InfyOm\Generator\Common\BaseRepository;

class StatusProcessingLawRepository extends BaseRepository
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
        return StatusProcessingLaw::class;
    }
}
