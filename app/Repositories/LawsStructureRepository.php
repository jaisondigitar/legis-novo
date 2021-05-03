<?php

namespace App\Repositories;

use App\Models\LawsStructure;
use InfyOm\Generator\Common\BaseRepository;

class LawsStructureRepository extends BaseRepository
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
        return LawsStructure::class;
    }
}
