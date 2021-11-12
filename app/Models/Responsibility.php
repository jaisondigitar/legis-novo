<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Responsibility",
 *      required={companies_id, name},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="companies_id",
 *          description="companies_id",
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
class Responsibility extends Model
{
    use SoftDeletes;

    public $table = 'responsibilities';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'companies_id',
        'name',
        'order',
        'skip_board'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'companies_id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'companies_id' => 'required',
        'name' => 'required'
    ];

    public function company(){
        return $this->belongsTo('App\Models\Company', 'companies_id');
    }

    public function Responsibilities(){
        return $this->hasMany(ResponsibilityAssemblyman::class);
    }

    public function assemblyman(){
        return $this->belongsToMany(Assemblyman::class, 'responsibility_assemblymen');
    }
}
