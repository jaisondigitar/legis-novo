<?php

namespace App\Repositories;

use App\Models\Responsibility;
use InfyOm\Generator\Common\BaseRepository;

class ResponsibilityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Responsibility::class;
    }
}
