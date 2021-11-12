<?php

namespace App\Repositories;

use App\Models\Meeting;

class MeetingRepository extends Repository
{
    protected $modelClass = Meeting::class;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'session_type_id',
        'session_place_id',
        'date_start',
        'date_end'
    ];
}
