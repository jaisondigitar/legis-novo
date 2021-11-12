<?php

namespace App\Repositories;

use App\Models\LawsTag;

class LawsTagRepository
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
        return LawsTag::class;
    }
}
