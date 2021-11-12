<?php

namespace App\Repositories;

class OfficeComissionRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
//        return OfficeComission::class;
    }
}
