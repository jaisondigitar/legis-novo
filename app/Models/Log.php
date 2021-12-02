<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="Log",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="owner_type",
 *          description="owner_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="owner_id",
 *          description="owner_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="old_value",
 *          description="old_value",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="new_value",
 *          description="new_value",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      )
 * )
 */
class Log extends Model
{
    public $table = 'audits';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'user_id',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'event',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'auditable_type' => 'string',
        'auditable_id' => 'integer',
        'old_values' => 'string',
        'new_values' => 'string',
        'event' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return string
     */
    public function getColor()
    {
        switch ($this->type) {
            case 'created':
                return 'success';
                break;
            case 'updated':
                return 'warning';
                break;
            case 'deleted':
                return 'danger';
                break;
            default:
                return 'primary';
                break;
        }
    }
}
