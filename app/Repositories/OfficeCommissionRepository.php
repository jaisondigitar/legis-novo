<?php

namespace App\Repositories;

use App\Models\OfficeCommission;
use InfyOm\Generator\Common\BaseRepository;

class OfficeCommissionRepository extends BaseRepository
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
        return OfficeCommission::class;
    }
}
