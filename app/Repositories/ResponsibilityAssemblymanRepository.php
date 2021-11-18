<?php

namespace App\Repositories;

use App\Models\ResponsibilityAssemblyman;

class ResponsibilityAssemblymanRepository
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
        return ResponsibilityAssemblyman::class;
    }
}
