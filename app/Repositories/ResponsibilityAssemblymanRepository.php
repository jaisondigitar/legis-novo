<?php

namespace App\Repositories;

use App\Models\ResponsibilityAssemblyman;
use InfyOm\Generator\Common\BaseRepository;

class ResponsibilityAssemblymanRepository extends BaseRepository
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
        return ResponsibilityAssemblyman::class;
    }
}
