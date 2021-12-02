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
