<?php

namespace App\Repositories;

use App\Models\AdviceSituationLaw;
use InfyOm\Generator\Common\BaseRepository;

class AdviceSituationLawRepository extends BaseRepository
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
        return AdviceSituationLaw::class;
    }
}
