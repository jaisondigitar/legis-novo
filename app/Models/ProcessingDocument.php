<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingDocument extends BaseModel
{
    use SoftDeletes;

    public $table = 'processing_documents';

    public $fillable = [
        'document_id',
        'document_situation_id',
        'status_processing_document_id',
        'processing_document_date',
        'obsevation',
        'processing_document_file',
        'destination_id',
    ];

    public static $translation = [
        'PROCESSINGDOCUMENT' => 'PROCESSANDO DOCUMENTO',
        'document_id' => 'Id do Documento',
        'document_situation_id' => 'Id da Situação do Documento',
        'status_processing_document_id',
        'status_processing_document_id' => 'Id do Status do Documento',
        'obsevation' => 'Observação',
        'processing_document_file' => 'Processamento de Arquivo de Documento',
        'destination_id' => 'Id de Destino',
    ];

    /**
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * @return BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * @return BelongsTo
     */
    public function documentSituation(): BelongsTo
    {
        return $this->belongsTo('App\Models\DocumentSituation', 'document_situation_id');
    }

    /**
     * @return BelongsTo
     */
    public function statusProcessingDocument(): BelongsTo
    {
        return $this->belongsTo('App\Models\StatusProcessingDocument', 'status_processing_document_id');
    }

    /**
     * @param $processing_document_date
     */
    public function setProcessingDocumentDateAttribute($processing_document_date)
    {
        $this->attributes['processing_document_date'] = Carbon::createFromFormat('d/m/Y', $processing_document_date);
    }

    /**
     * @param $processing_document_date
     * @return string
     */
    public function getProcessingDocumentDateAttribute($processing_document_date): string
    {
        return $this->asDateTime($processing_document_date)->format('d/m/Y');
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
     * @return BelongsTo
     */
    public function adviceSituationDocument(): BelongsTo
    {
        return $this->belongsTo('App\Models\AdviceSituationDocuments', 'advice_situation_documents_id');
    }

    /**
     * @return BelongsTo
     */
    public function advicePublicationDocument(): BelongsTo
    {
        return $this->belongsTo('App\Models\AdvicePublicationDocuments', 'advice_publication_documents_id');
    }
}
