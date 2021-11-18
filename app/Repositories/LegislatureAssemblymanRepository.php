<?php

namespace App\Repositories;

use App\Models\LegislatureAssemblyman;

class LegislatureAssemblymanRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LegislatureAssemblyman::class;
    }
}
