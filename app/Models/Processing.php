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
        'date_end',
    ];

    public static $translation = [
        'PROCESSING' => 'EM PROCESSAMENTO',
        'law_projects_id' => 'Id da Lei do Projeto',
        'advice_publication_id' => 'ID de Publicação de Conselho',
        'advice_situation_id' => 'Id da Situação do Conselho',
        'status_processing_law_id' => 'Id de Lei de Processamento de Status',
        'processing_date' => 'Processando Dados',
        'obsevation' => 'Observação',
        'processing_file' => 'Processando Arquivo',
        'destination_id' => 'Id de Destino',
        'date_end' => 'Prazo',
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
     * @return HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class);
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
     * @param $created_at
     * @return string
     */
    public function getCreatedAtAttribute($created_at): string
    {
        return $this->asDateTime($created_at)->format('d/m/Y H:i');
    }

    /**
     * @param $date_end
     */
    public function setDateEndAttribute($date_end)
    {
        $this->attributes['date_end'] = Carbon::createFromFormat('d/m/Y', $date_end);
    }

    /**
     * @param $date_end
     * @return string
     */
    public function getDateEndAttribute($date_end)
    {
        return isset($date_end) ? $this->asDateTime($date_end)->format('d/m/Y') : null;
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
