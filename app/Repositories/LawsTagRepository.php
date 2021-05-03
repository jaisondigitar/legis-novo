<?php

namespace App\Repositories;

use App\Models\LawsTag;
use InfyOm\Generator\Common\BaseRepository;

class LawsTagRepository extends BaseRepository
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
        return LawsTag::class;
    }
}
