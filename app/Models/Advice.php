<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Advice",
 *      required={"date", "type", "to_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="to_id",
 *          description="to_id",
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
class Advice extends BaseModel
{
    use SoftDeletes;

    public $table = 'advices';

    public $fillable = [
        'date',
        'type',
        'to_id',
        'laws_projects_id',
        'description',
        'legal_option',
        'date_end',
    ];

    public static $translation = [
        'ADVICE' => 'CONSELHO',
        'date' => 'Data',
        'description' => 'Descrição',
        'type' => 'Tipo',
        'laws_projects_id' => 'Id da Lei do Projeto',
        'to_id' => 'Para',
        'legal_option' => 'Parecer Jurídico',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'to_id' => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [];

    /**
     * @param $date_end
     */
    public function setDateEndAttribute($date_end)
    {
        if ($date_end) {
            $this->attributes['date_end'] = Carbon::createFromFormat('d/m/Y', $date_end);
        } else {
            $this->attributes['date_end'] = null;
        }
    }

    /**
     * @param $date_end
     * @return string
     */
    public function getDateEndAttribute($date_end)
    {
        return isset($date_end) ? $this->asDateTime($date_end)->format('d/m/Y') : null;
    }

    public function getDateAttribute($date): string
    {
        return $this->asDateTime($date)->format('d/m/Y H:i');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y H:i', $date);
    }

    public function destination()
    {
        return $this->belongsTo(Commission::class, 'to_id');
    }

    public function situation()
    {
        return $this->hasMany(AdviceSituation::class, 'advice_id');
    }

    public function commission()
    {
        return $this->belongsTo('\App\Models\Commission', 'to_id');
    }

    public function project()
    {
        return $this->belongsTo('\App\Models\LawsProject', 'laws_projects_id');
    }

    public function document()
    {
        return $this->belongsTo('\App\Models\Document', 'document_id');
    }

    public function awnser()
    {
        return $this->hasMany('\App\Models\AdviceAwnser', 'advice_id', 'id');
    }

    public function voting()
    {
        return $this->hasOne(Voting::class);
    }
}
