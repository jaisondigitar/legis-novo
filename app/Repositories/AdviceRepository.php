<?php

namespace App\Repositories;

use App\Models\Advice;
use InfyOm\Generator\Common\BaseRepository;

class AdviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date',
        'type',
        'to_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Advice::class;
    }
}
