<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class State extends Model
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
