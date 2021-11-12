<?php

namespace App\Repositories;

use App\Models\Test;

class TestRepository
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
        return Test::class;
    }
}
