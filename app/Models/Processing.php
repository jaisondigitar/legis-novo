<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Processing extends BaseModel
{
    use SoftDeletes;

    public $table = 'processings';

    public $fillable = [
        'law_projects_id',
        'advice_publication_id',
        'advice_situation_id',
        'status_processing_law_id',
        'processing_date',
        'obsevation',
        'processing_file',
        'destination_id',
    ];

    /**
     * @return BelongsTo
     */
    public function lawsProject(): BelongsTo
    {
        return $this->belongsTo(LawsProject::class);
    }

    /**
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * @param $processing_date
     */
    public function setProcessingDateAttribute($processing_date)
    {
        $this->attributes['processing_date'] = Carbon::createFromFormat('d/m/Y', $processing_date);
    }

    /**
     * @param $processing_date
     * @return string
     */
    public function getProcessingDateAttribute($processing_date): string
    {
        return $this->asDateTime($processing_date)->format('d/m/Y');
    }

    /**
     * @return BelongsTo
     */
    public function adviceSituationLaw(): BelongsTo
    {
        return $this->belongsTo('App\Models\AdviceSituationLaw', 'advice_situation_id');
    }

    /**
     * @return BelongsTo
     */
    public function advicePublicationLaw(): BelongsTo
    {
        return $this->belongsTo('App\Models\AdvicePublicationLaw', 'advice_publication_id');
    }

    /**
     * @return BelongsTo
     */
    public function statusProcessingLaw(): BelongsTo
    {
        return $this->belongsTo('App\Models\StatusProcessingLaw', 'status_processing_law_id');
    }
}
