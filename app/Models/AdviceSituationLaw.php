<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="AdviceSituationLaw",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
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
class AdviceSituationLaw extends BaseModel
{
    use SoftDeletes;

    public $table = 'advice_situation_laws';

    public $fillable = [
        'name',
    ];

    public static $translation = [
        'ADVICESITUATIONLAW' => 'LEI DE SITUAÇÃO DE CONSELHOS',
        'name' => 'Nome',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'=>'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name'=>'required',
    ];
}
