<?php

namespace App\Models;

class TypesOfAttendance extends BaseModel
{
    protected $table = 'types_of_attendance';

    protected $fillable = [
        'name',
    ];

    public static $rules = [
        'name' => 'required',
    ];
}
