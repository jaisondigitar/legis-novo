<?php

namespace App\Repositories;

use App\Models\LawSituation;
use InfyOm\Generator\Common\BaseRepository;

class LawSituationRepository extends BaseRepository
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
        return LawSituation::class;
    }
}
