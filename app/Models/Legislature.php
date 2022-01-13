<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Legislature",
 *      required={companies_id, from, to},
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
 *          property="from",
 *          description="from",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="to",
 *          description="to",
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
class Legislature extends BaseModel
{
    use SoftDeletes;

    public $table = 'legislatures';

    public $fillable = [
        'companies_id',
        'from',
        'to',
    ];

    public static $translation = [
        'LEGISLATURE' => 'LEGISLATURA',
        'companies_id' => 'Id do Setor',
        'from' => 'De',
        'to' => 'Até',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'companies_id' => 'integer',
        'from' => 'date',
        'to' => 'date',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'companies_id' => 'required',
        'from' => 'required',
        'to' => 'required',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'companies_id');
    }

    public function legislature_assemblyman()
    {
        return $this->hasMany(LegislatureAssemblyman::class, 'legislature_id');
    }

    public function setFromAttribute($from)
    {
        $this->attributes['from'] = Carbon::createFromFormat('d/m/Y', $from);
    }

    public function getFromAttribute($from)
    {
        return $this->asDateTime($from)->format('d/m/Y');
    }

    public function setToAttribute($to)
    {
        $this->attributes['to'] = Carbon::createFromFormat('d/m/Y', $to);
    }

    public function getToAttribute($to)
    {
        return $this->asDateTime($to)->format('d/m/Y');
    }
}
