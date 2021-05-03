<?php

namespace App\Repositories;

use App\Models\OfficeComission;
use InfyOm\Generator\Common\BaseRepository;

class OfficeComissionRepository extends BaseRepository
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
        return OfficeComission::class;
    }
}
