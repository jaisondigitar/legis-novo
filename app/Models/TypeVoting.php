<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TypeVoting extends BaseModel
{
    use SoftDeletes;

    public $table = 'type_votings';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'anonymous',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];
}
