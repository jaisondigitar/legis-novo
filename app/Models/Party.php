<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Party",
 *      required={companies_id, prefix, name},
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
class Party extends BaseModel
{
    use SoftDeletes;

    public $table = 'parties';

    public $fillable = [
        'companies_id',
        'prefix',
        'name',
    ];

    public static $translation = [
        'PARTY' => 'PARTIDOS',
        'companies_id' => 'Id do Setor',
        'prefix' => 'Prefixo',
        'name' => 'Nome',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'companies_id' => 'integer',
        'prefix' => 'string',
        'name' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'companies_id' => 'required',
        'prefix' => 'required',
        'name' => 'required',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'companies_id');
    }
}
