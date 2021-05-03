<?php

namespace App\Repositories;

use App\Models\ComissionSituation;
use InfyOm\Generator\Common\BaseRepository;

class ComissionSituationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ComissionSituation::class;
    }
}
