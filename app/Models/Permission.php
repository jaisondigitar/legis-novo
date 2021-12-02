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
