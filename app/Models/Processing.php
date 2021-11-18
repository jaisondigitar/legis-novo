<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Processing extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $table = 'processings';

    public $fillable = [
        'law_projects_id',
        'advice_publication_id',
        'advice_situation_id',
        'status_processing_law_id',
        'processing_date',
        'obsevation',
        'processing_file',
    ];

    public function lawsProject()
    {
        return $this->belongsTo(LawsProject::class);
    }

    public function setProcessingDateAttribute($processing_date)
    {
        $this->attributes['processing_date'] = Carbon::createFromFormat('d/m/Y', $processing_date);
    }

    public function getProcessingDateAttribute($processing_date)
    {
        return $this->asDateTime($processing_date)->format('d/m/Y');
    }

    public function adviceSituationLaw()
    {
        return $this->belongsTo('App\Models\AdviceSituationLaw', 'advice_situation_id');
    }

    public function advicePublicationLaw()
    {
        return $this->belongsTo('App\Models\AdvicePublicationLaw', 'advice_publication_id');
    }

    public function statusProcessingLaw()
    {
        return $this->belongsTo('App\Models\StatusProcessingLaw', 'status_processing_law_id');
    }
}
