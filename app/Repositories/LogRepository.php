<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Log::class;
    }
}
