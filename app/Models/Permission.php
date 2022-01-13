<?php

namespace App\Models;

class Permission extends BaseModel
{
    public $table = 'permissions';

    public $fillable = [
        'id',
        'name',
        'readable_name',
        'created_at',
        'updated_at',
    ];

    public static $translation = [
        'PERMISSION' => 'PERMISSÃO',
        'id' => 'Id',
        'name' => 'Nome',
        'readable_name' => 'Nome Legível',
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
        'readable_name' => 'string',
    ];

    public static $rules = [
        'name' => 'required',
        'readable_name' => 'required',
    ];
}
