<?php

namespace App\Models;

use Eloquent as Model;
use OwenIt\Auditing\AuditingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="LawsStructure",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
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
class LawsStructure extends Model
{
    use SoftDeletes;

    use AuditingTrait;

    public $table = 'laws_structures';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'prefix'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    public function showName()
    {
        return  $this->prefix ? $this->prefix : $this->name;
    }
}
