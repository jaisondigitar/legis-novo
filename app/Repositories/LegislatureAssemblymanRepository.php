<?php

namespace App\Repositories;

use App\Models\LegislatureAssemblyman;
use InfyOm\Generator\Common\BaseRepository;

class LegislatureAssemblymanRepository extends BaseRepository
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
