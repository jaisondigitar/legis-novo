<?php

namespace App\Repositories;

use App\Models\Log;
use InfyOm\Generator\Common\BaseRepository;

class LogRepository extends BaseRepository
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
