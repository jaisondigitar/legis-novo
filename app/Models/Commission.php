<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Commission extends Model
{
    use SoftDeletes;

    public $table = 'commissions';

    protected $dates = ['deleted_at', 'date_start', 'date_end'];

    public $fillable = [
        'date_start',
        'date_end',
        'name',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
        'name' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function scopeActive($query)
    {
        return $query->whereDate('date_end', '>=', date('Y-m-d', time()));
    }

    public function setDateStartAttribute($date_start)
    {
        $this->attributes['date_start'] = Carbon::createFromFormat('d/m/Y', $date_start);
    }

    public function getDateStartAttribute($date_start)
    {
        return $this->asDateTime($date_start)->format('d/m/Y');
    }

    public function setDateEndAttribute($date_end)
    {
        $this->attributes['date_end'] = Carbon::createFromFormat('d/m/Y', $date_end);
    }

    public function getDateEndAttribute($date_end)
    {
        return $this->asDateTime($date_end)->format('d/m/Y');
    }

    public function advices()
    {
        return $this->hasMany('\App\Models\Advice', 'to_id', 'id');
    }

    public function projects()
    {
        return $this->belongsToMany('\App\Models\LawsProject', 'advices', 'to_id', 'laws_projects_id')->closed();
    }

    public function documents()
    {
        return $this->belongsToMany('\App\Models\Document', 'advices', 'to_id', 'document_id');
    }

    public function awnsers()
    {
        return $this->belongsToMany('\App\Models\AdviceAwnser', 'advices', 'to_id', 'advice_id');
    }

    public function scopeClosed($query)
    {
        return $query->where('closed', 1);
    }
}
