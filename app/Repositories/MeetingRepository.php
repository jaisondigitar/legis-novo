<?php

namespace App\Repositories;

use App\Models\Meeting;

class MeetingRepository extends Repository
{
    /**
     * @var string
     */
    protected $modelClass = Meeting::class;
}
