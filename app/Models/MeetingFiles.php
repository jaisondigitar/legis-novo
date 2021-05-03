<?php

namespace App\Models;

use Eloquent as Model;
use OwenIt\Auditing\AuditingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="MeetingFiles",
 *      required={"meeting_id", "filename"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="meeting_id",
 *          description="meeting_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="filename",
 *          description="filename",
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
class MeetingFiles extends Model
{
    use SoftDeletes;

    use AuditingTrait;

    public $table = 'meeting_files';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'meeting_id',
        'filename'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'meeting_id' => 'integer',
        'filename' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'meeting_id' => 'required',
        'filename' => 'required'
    ];


    public function meeting(){
        return $this->belongsTo('App\Models\Meeting', 'meeting_id');
    }
}
