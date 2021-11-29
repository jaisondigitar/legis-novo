<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Attendance extends Model
{
    public $table = 'attendance';

    public $fillable = [
        'date',
        'time',
        'description',
        'type_id',
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
    ];

    public function people()
    {
        return $this->hasOne(People::class, 'id', 'people_id');
    }

    public function type()
    {
        return $this->hasOne(TypesOfAttendance::class, 'id', 'type_id');
    }
}
