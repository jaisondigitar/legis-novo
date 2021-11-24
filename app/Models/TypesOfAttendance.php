<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypesOfAttendance extends Model
{
    protected $table = 'types_of_attendance';

    protected $fillable = [
        'name',
    ];
}
