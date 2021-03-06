<?php

namespace App\Models;

/**
 * @SWG\Definition(
 *      definition="AdviceSituation",
 *      required={"advice_id", "comission_situation_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="advice_id",
 *          description="advice_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="comission_situation_id",
 *          description="comission_situation_id",
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
class AdviceSituation extends BaseModel
{
    public $table = 'advice_situations';

    public $fillable = [
        'advice_id',
        'comission_situation_id',
    ];

    public static $translation = [
        'ADVICESITUATION' => 'SITUAÇÃO DE CONSELHOS',
        'advice_id' => 'Id da Situação',
        'comission_situation_id' => 'Id da Situação da Comissão',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'advice_id' => 'integer',
        'comission_situation_id' => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'advice_id' => 'required',
        'comission_situation_id' => 'required',
    ];

    public function situation()
    {
        return $this->belongsTo(ComissionSituation::class, 'comission_situation_id');
    }
}
