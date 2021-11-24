<?php

namespace App\Repositories;

use App\Models\TypesOfAttendance;

class TypesOfAttendanceRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelClass = TypesOfAttendance::class;
}
