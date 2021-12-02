<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends BaseModel
{
    use SoftDeletes;

    public $table = 'modules';

    public $fillable = [
        'name',
        'token',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'token' => 'string',
        'active' => 'integer',
    ];

    public static $rules = [
        'name' => 'required',
        'token' => 'required',
    ];

    public function isActive($module)
    {
        return self::where('name', $module)->first()->active;
    }
}
