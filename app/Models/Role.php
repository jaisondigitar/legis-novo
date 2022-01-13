<?php

namespace App\Models;

class Role extends BaseModel
{
    public $table = 'roles';

    public $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public static $translation = [
        'ROLE' => 'GRUPO DE PERMISSÕES',
        'id' => 'Id',
        'name' => 'Nome',
        'created_at' => 'Data de Criação',
        'updated_at' => 'Data de Atualização',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public static $rules = [

    ];
}
