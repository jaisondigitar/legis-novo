<?php

namespace App\Models;

class Attendance extends BaseModel
{
    public $table = 'attendance';

    public $fillable = [
        'date',
        'time',
        'description',
        'type_id',
        'sector_id',
        'people_id',
    ];

    /**
     *Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'cpf' => 'required',
        'date' => 'required',
        'time' => 'required',
        'description' => 'required',
        'type_id' => 'required',
        'sector_id' => 'required',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function people()
    {
        return $this->hasOne(People::class, 'id', 'people_id');
    }

    public function type()
    {
        return $this->hasOne(TypesOfAttendance::class, 'id', 'type_id');
    }
}
