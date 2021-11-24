<?php

namespace App\Models;

use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="Document",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="document_type_id",
 *          description="document_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          description="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="session_date",
 *          description="session_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="read",
 *          description="read",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="approved",
 *          description="approved",
 *          type="boolean"
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
class DocumentProtocol extends Model
{
    public $table = 'document_protocol';

    public $fillable = [
        'document_id',
        'protocol_type_id',
        'number',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'document_id' => 'integer',
        'protocol_type_id' => 'integer',
        'number' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id');
    }

    public function protocol_type()
    {
        return $this->belongsTo('App\Models\ProtocolType', 'protocol_type_id');
    }
}
