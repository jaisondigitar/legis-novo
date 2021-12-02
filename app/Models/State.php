<?php

namespace App\Models;

class State extends BaseModel
{
    public $table = 'states';

    public $fillable = [
        'id',
        'uf',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uf' => 'string',
        'name' => 'string',
    ];

    public static $rules = [

    ];
}
