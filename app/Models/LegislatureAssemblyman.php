<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="LegislatureAssemblyman",
 *      required={},
 *      @SWG\Property(
 *          property="legislature_id",
 *          description="legislature_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="assemblyman_id",
 *          description="assemblyman_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class LegislatureAssemblyman extends Model
{
    use SoftDeletes;

    public $table = 'legislature_assemblymen';

    public $primaryKey = 'assemblyman_id';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'legislature_id',
        'assemblyman_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'legislature_id' => 'integer',
        'assemblyman_id' => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function legislature()
    {
        return $this->belongsTo(Legislature::class, 'legislature_id');
    }

    public function assemblyman()
    {
        return $this->belongsTo(Assemblyman::class, 'assemblyman_id');
    }
}
