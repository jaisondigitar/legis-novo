<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository extends Repository
{
    /**
     * @var string
     */
    protected $modelClass = Log::class;
}
