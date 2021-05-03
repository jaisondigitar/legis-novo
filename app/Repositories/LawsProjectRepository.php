<?php

namespace App\Repositories;

use App\Models\LawsProject;
use InfyOm\Generator\Common\BaseRepository;

class LawsProjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'law_type_id',
        'law_place_id',
        'law_number',
        'title'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LawsProject::class;
    }
}
