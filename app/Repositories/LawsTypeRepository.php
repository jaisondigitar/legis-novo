<?php

namespace App\Repositories;

use App\Models\LawsType;
use InfyOm\Generator\Common\BaseRepository;

class LawsTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LawsType::class;
    }
}
