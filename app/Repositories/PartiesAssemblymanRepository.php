<?php

namespace App\Repositories;

use App\Models\PartiesAssemblyman;

class PartiesAssemblymanRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return PartiesAssemblyman::class;
    }
}
