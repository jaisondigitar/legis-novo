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

    public static $translation = [
        'ATTENDANCE' => 'ATENDIMENTO',
        'date' => 'Data',
        'time' => 'Horário',
        'description' => 'Descrição',
        'type_id' => 'Id do Tipo',
        'sector_id' => 'Id do Setor',
        'people_id' => 'Id da Pessoa',
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

    public function scopeByIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeByDateDesc($query)
    {
        return $query->orderBy('date', 'desc');
    }

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
