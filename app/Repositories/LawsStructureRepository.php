<?php

namespace App\Repositories;

use App\Models\LawsStructure;

class LawsStructureRepository
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
