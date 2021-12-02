<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @SWG\Definition(
 *      definition="Commission",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date_start",
 *          description="date_start",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="date_end",
 *          description="date_end",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
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
class CommissionAssemblyman extends BaseModel
{
    public $table = 'commission_assemblyman';

    public $fillable = [
        'commission_id',
        'assemblyman_id',
        'office',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'commission_id' => 'integer',
        'assemblyman_id' => 'integer',
        'office' => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function commissions()
    {
        return $this->hasMany('App\Models\Commission', 'id', 'commission_id');
    }

    public function assemblyman()
    {
        return $this->belongsTo('App\Models\Assemblyman', 'assemblyman_id');
    }

    public function office_commission()
    {
        return $this->belongsTo('App\Models\OfficeCommission', 'office');
    }

    public function setStartDateAttribute($start_date)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $start_date);
    }

    public function getStartDateAttribute($start_date)
    {
        return $this->asDateTime($start_date)->format('d/m/Y');
    }

    public function setEndDateAttribute($end_date)
    {
        $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $end_date);
    }

    public function getEndDateAttribute($end_date)
    {
        return $this->asDateTime($end_date)->format('d/m/Y');
    }
}
