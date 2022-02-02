<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

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
class Document extends BaseModel
{
    use SoftDeletes;

    public $table = 'documents';

    public $fillable = [
        'document_type_id',
        'users_id',
        'owner_id',
        'sector_id',
        'number',
        'content',
        'date',
        'session_date',
        'read',
        'approved',
        'updated_at',
        'resume',
        'original_file',
        'with_attachments_file',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'document_type_id' => 'integer',
        'users_id' => 'integer',
        'number' => 'string',
        'content' => 'string',
        'date' => 'date',
        'session_date' => 'date',
        'read' => 'boolean',
        'approved' => 'boolean',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'date' => 'required',
        'document_type_id' => 'required',
        'sector_id' => 'nullable|integer',
        'owner_id' => 'required',
        'content' => 'required',
        'assemblymen' => 'nullable|array',
        'assemblymen.*' => 'nullable|integer',
    ];

    public function documentNumber()
    {
        return $this->belongsTo(DocumentNumber::class, 'document_id');
    }

    public function externalSector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\Assemblyman', 'owner_id');
    }

    public function assemblyman()
    {
        return $this->belongsToMany('App\Models\Assemblyman', 'document_assemblyman');
    }

    public function getRealDate()
    {
        return $this->date;
    }

    public function documents()
    {
        return $this->hasMany('App\Models\DocumentFiles', 'document_id');
    }

    public function processingDocument()
    {
        return $this->hasMany('App\Models\ProcessingDocument', 'document_id', 'id');
    }

    public function document_type()
    {
        return $this->belongsTo('App\Models\DocumentType', 'document_type_id');
    }

    public function document_protocol()
    {
        return $this->hasOne('App\Models\DocumentProtocol', 'document_id');
    }

    public function advices()
    {
        return $this->hasMany('App\Models\Advice', 'document_id', 'id');
    }

    public function adviceSituationDocument()
    {
        return $this->belongsTo('App\Models\AdviceSituationDocuments', 'advice_situation_id');
    }

    public function advicePublicationDocument()
    {
        return $this->belongsTo('App\Models\AdvicePublicationDocuments', 'advice_publication_id');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $date);
    }

    public function getDateAttribute($date)
    {
        return $this->asDateTime($date)->format('d/m/Y');
    }

    public function getDateC($date)
    {
        return $this->asDateTime($date)->format('Y/m/d');
    }

    public function getYear($date)
    {
        $date = explode('/', $date);

        return $date[2];
    }

    public function scopeByIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeByDateDesc($query)
    {
        return $query->orderBy('date', 'desc');
    }

    public function document_number()
    {
        return $this->hasMany(DocumentNumber::class);
    }

    public function scopeGetNumber()
    {
        $number = $this->document_number()->get()->last();

        if ($number) {
            $number = strtotime($number->date);

            return $number;
        }

        return json_encode(false);
    }

    public function voting()
    {
        return $this->hasOne(Voting::class);
    }

    public function getName()
    {
        $str = '';

        if ($this->document_type->parent_id) {
            $str .= $this->document_type->parent->name.' :: ';
        }
        $str .= $this->document_type->name.' - ';

        if ($this->number == 0) {
            $str .= ' - ';
        } else {
            $str .= $this->number.'/'.$this->getYear($this->date);
        }

        return $str;
    }

    /**
     * @return bool
     */
    public function getIsProtocoledAttribute(): bool
    {
        return self::document_protocol()->get()->isNotEmpty();
    }

    /**
     * @return mixed
     */
    public function getTypeAttribute()
    {
        return $this->document_type->parent_id ?
            $this->document_type->parent :
            $this->document_type;
    }
}
