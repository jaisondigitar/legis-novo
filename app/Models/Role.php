<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Role extends Model
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
