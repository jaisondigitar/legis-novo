<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="LawsProject",
 *      required={"title"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="law_type_id",
 *          description="law_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="law_place_id",
 *          description="law_place_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="law_number",
 *          description="law_number",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="project_number",
 *          description="project_number",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="sub_title",
 *          description="sub_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="assemblyman_id",
 *          description="assemblyman_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_ready",
 *          description="is_ready",
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
class LawsProject extends Model
{
    use SoftDeletes;

    public $table = 'laws_projects';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'law_type_id',
        'law_place_id',
        'law_date',
        'law_date_publish',
        'law_number',
        'project_number',
        'title',
        'sufix',
        'sub_title',
        'assemblyman_id',
        'is_ready',
        'is_read',
        'updated_at',
        'reference_id',
        'situation_id',
        'date_presentation',
        'file',
        'law_file',
        'justify',
        'protocol',
        'protocoldate',
        'advice_situation_id',
        'advice_publication_id',
        'advice_date',
        'first_discussion',
        'second_discussion',
        'third_discussion',
        'single_discussion',
        'special_urgency',
        'approved',
        'sanctioned',
        'Promulgated',
        'Rejected',
        'Vetoed',
        'Filed',
        'sustained',
        'observation',
        'town_hall',
        'comission_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'law_type_id' => 'integer',
        'law_place_id' => 'integer',
        'law_number' => 'integer',
        'project_number' => 'integer',
        'title' => 'string',
        'sub_title' => 'string',
        'assemblyman_id' => 'integer',
        'is_ready' => 'boolean',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'law_type_id' => 'required',
        'law_date' => 'required',
        'title' => 'required',
        'sub_title' => 'required',
        'assemblyman_id' => 'required',
        'situation_id' => 'required',
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\Assemblyman', 'assemblyman_id');
    }

    public function lawFiles()
    {
        return $this->hasMany('App\Models\LawFile', 'law_project_id');
    }

    public function adviceSituationLaw()
    {
        return $this->belongsTo('App\Models\AdviceSituationLaw', 'advice_situation_id');
    }

    public function advicePublicationLaw()
    {
        return $this->belongsTo('App\Models\AdvicePublicationLaw', 'advice_publication_id');
    }

    public function comission()
    {
        return $this->belongsTo('App\Models\Commission', 'comission_id', 'id');
    }

    public function processing()
    {
        return $this->hasMany('App\Models\Processing', 'law_projects_id', 'id');
    }

    public function advices()
    {
        return $this->hasMany('App\Models\Advice', 'laws_projects_id', 'id');
    }

    public function situation()
    {
        return $this->belongsTo('App\Models\LawSituation', 'situation_id');
    }

    public function lawProject()
    {
        return $this->belongsTo('App\Models\LawsProject', 'reference_id');
    }

    public function setLawDateAttribute($law_date)
    {
        $this->attributes['law_date'] = Carbon::createFromFormat('d/m/Y', $law_date);
    }

    public function getLawDateAttribute($law_date)
    {
        return $this->asDateTime($law_date)->format('d/m/Y');
    }

    public function setProtocoldateAttribute($protocoldate)
    {
        if ($protocoldate) {
            $this->attributes['protocoldate'] = Carbon::createFromFormat('d/m/Y', $protocoldate);
        }
    }

    public function getProtocoldateAttribute($protocoldate)
    {
        return $this->asDateTime($protocoldate)->format('d/m/Y');
    }

    public function setDatePresentationAttribute($date)
    {
        if ($date) {
            $this->attributes['date_presentation'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['date_presentation'] = '';
        }
    }

    public function getDatePresentationAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setLawDatePublishAttribute($law_date_publish)
    {
        if ($law_date_publish) {
            $this->attributes['law_date_publish'] = Carbon::createFromFormat('d/m/Y', $law_date_publish);
        } else {
            $this->attributes['law_date_publish'] = '';
        }
    }

    public function getLawDatePublishAttribute($law_date_publish)
    {
        if ($law_date_publish != '0000-00-00 00:00:00') {
            return $this->asDateTime($law_date_publish)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function law_type()
    {
        return $this->belongsTo(LawsType::class);
    }

    public function law_place()
    {
        return $this->belongsTo(LawsPlace::class, 'law_place_id');
    }

    public function assemblyman()
    {
        return $this->belongsTo(Assemblyman::class, 'assemblyman_id');
    }

    public function getYearLaw($law_date)
    {
        $date = explode('/', $law_date);

        return $date[2];
    }

    public function getYearLawPublish($law_date_publish)
    {
        if ($law_date_publish) {
            $date = explode('/', $law_date_publish);

            return $date[2];
        }
    }

    public function scopeByIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeClosed($query)
    {
        return $query->where('closed', 1);
    }

    public function scopeByDateDesc($query)
    {
        return $query->orderBy('law_date', 'desc');
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('law_number');
    }

    public function scopeUnRead($query)
    {
        return $query->where('is_ready', 0);
    }

    // mutator parecer law

    public function setAdviceDateAttribute($date)
    {
        if ($date) {
            $this->attributes['advice_date'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['advice_date'] = '';
        }
    }

    public function getAdviceDateAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setFirstDiscussionAttribute($date)
    {
        if ($date) {
            $this->attributes['first_discussion'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['first_discussion'] = '';
        }
    }

    public function getFirstDiscussionAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setSecondDiscussionAttribute($date)
    {
        if ($date) {
            $this->attributes['second_discussion'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['second_discussion'] = '';
        }
    }

    public function getSecondDiscussionAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setThirdDiscussionAttribute($date)
    {
        if ($date) {
            $this->attributes['third_discussion'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['third_discussion'] = '';
        }
    }

    public function getThirdDiscussionAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setSingleDiscussionAttribute($date)
    {
        if ($date) {
            $this->attributes['single_discussion'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['single_discussion'] = '';
        }
    }

    public function getSingleDiscussionAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setSpecialUrgencyAttribute($date)
    {
        if ($date) {
            $this->attributes['special_urgency'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['special_urgency'] = '';
        }
    }

    public function getSpecialUrgencyAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setApprovedAttribute($date)
    {
        if ($date) {
            $this->attributes['approved'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['approved'] = '';
        }
    }

    public function getApprovedAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setSanctionedAttribute($date)
    {
        if ($date) {
            $this->attributes['sanctioned'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['sanctioned'] = '';
        }
    }

    public function getSanctionedAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setPromulgatedAttribute($date)
    {
        if ($date) {
            $this->attributes['Promulgated'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['Promulgated'] = '';
        }
    }

    public function getPromulgatedAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setRejectedAttribute($date)
    {
        if ($date) {
            $this->attributes['Rejected'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['Rejected'] = '';
        }
    }

    public function getRejectedAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setVetoedAttribute($date)
    {
        if ($date) {
            $this->attributes['Vetoed'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['Vetoed'] = '';
        }
    }

    public function getVetoedAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setFiledAttribute($date)
    {
        if ($date) {
            $this->attributes['Filed'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['Filed'] = '';
        }
    }

    public function getFiledAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function setSustainedAttribute($date)
    {
        if ($date) {
            $this->attributes['sustained'] = Carbon::createFromFormat('d/m/Y', $date);
        } else {
            $this->attributes['sustained'] = '';
        }
    }

    public function getSustainedAttribute($date)
    {
        if ($date != '0000-00-00') {
            return $this->asDateTime($date)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function law_project_number()
    {
        return $this->hasMany(LawProjectsNumber::class);
    }

    public function getNumberLaw()
    {
        $number = $this->law_project_number()->get()->last();

        if ($number) {
            $number = strtotime($number->date);

            return $number;
        }

        return json_encode(false);
    }

    public function voting()
    {
        return $this->hasOne(Voting::class, 'law_id', 'id');
    }

    public function getName()
    {
        return ! $this->law_type ? $this->law_type_id : mb_strtoupper($this->law_type->name, 'UTF-8');
    }
}
