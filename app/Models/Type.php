<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Type",
 *      required={prefix, name},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="prefix",
 *          description="prefix",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Type extends Model
{
    use SoftDeletes;

    public $table = 'types';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'prefix',
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'prefix' => 'string',
        'name' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'prefix' => 'required',
        'name' => 'required',
    ];
}
