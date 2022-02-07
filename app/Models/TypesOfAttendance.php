<?php

namespace App\Models;

class TypesOfAttendance extends BaseModel
{
    protected $table = 'types_of_attendance';

    protected $fillable = [
        'name',
        'active',
    ];

    public static $translation = [
        'TYPESOFATTENDANCE' => 'TIPO DE ATENDIMENTO',
        'name' => 'Nome',
        'active' => 'Ativo',
    ];

    public static $rules = [
        'name' => 'required',
        'active' => 'required',
    ];
}
