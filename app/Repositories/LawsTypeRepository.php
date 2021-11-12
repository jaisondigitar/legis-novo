<?php

namespace App\Repositories;

use App\Models\LawsType;

class LawsTypeRepository
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
        return LawsType::class;
    }
}
