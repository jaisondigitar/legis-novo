<?php

namespace App\Repositories;

use App\Models\Attendance;

class AttendanceRepository extends Repository
{
    protected $fieldSearchable = [
        'date',
        'time',
        'description',
        'people_id',
        'type_id',
    ];

    protected $modelClass = Attendance::class;
}
