<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ResponsibilityAssemblyman",
 *      required={},
 *      @SWG\Property(
 *          property="responsibility_id",
 *          description="responsibility_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="assemblyman_id",
 *          description="assemblyman_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="date",
 *          type="string",
 *          format="date"
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
class ResponsibilityAssemblyman extends BaseModel
{
    use SoftDeletes;

    public $table = 'responsibility_assemblymen';

    public $fillable = [
        'responsibility_id',
        'assemblyman_id',
        'date',
    ];

    public static $translation = [
        'RESPONSIBILITYASSEMBLYMAN' => 'RESPONSABILIDADE',
        'responsibility_id' => 'Id da Responsabilidade',
        'assemblyman_id' => 'Responsável',
        'date' => 'Data',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'responsibility_id' => 'integer',
        'assemblyman_id' => 'integer',
        'date' => 'date',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $date);
    }

    public function getDateAttribute($date)
    {
        return $this->asDateTime($date)->format('d/m/Y');
    }

    public function responsibility()
    {
        return $this->belongsTo(Responsibility::class, 'responsibility_id');
    }

    public function assemblyman()
    {
        return $this->belongsTo(Assemblyman::class, 'assemblyman_id');
    }
}
