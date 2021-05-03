<?php

namespace App\Repositories;

use App\Models\PartiesAssemblyman;
use InfyOm\Generator\Common\BaseRepository;

class PartiesAssemblymanRepository extends BaseRepository
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
        return PartiesAssemblyman::class;
    }
}
