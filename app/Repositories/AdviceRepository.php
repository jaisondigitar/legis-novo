<?php

namespace App\Repositories;

use App\Models\Advice;

class AdviceRepository
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
