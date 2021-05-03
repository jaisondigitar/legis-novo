<?php

namespace App\Repositories;

use App\Models\Legislature;
use InfyOm\Generator\Common\BaseRepository;

class LegislatureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'from',
        'to'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Legislature::class;
    }
}
