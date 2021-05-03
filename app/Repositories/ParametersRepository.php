<?php

namespace App\Repositories;

use App\Models\Parameters;
use InfyOm\Generator\Common\BaseRepository;

class ParametersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'slug',
        'value'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Parameters::class;
    }
}
