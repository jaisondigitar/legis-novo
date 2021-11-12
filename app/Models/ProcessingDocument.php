<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ProcessingDocument extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $table = 'processing_documents';

    public $fillable = [
        'document_id',
        'document_situation_id',
        'status_processing_document_id',
        'processing_document_date',
        'obsevation',
        'processing_document_file'
    ];

    public function document(){
        return $this->belongsTo(Document::class);
    }

    public function documentSituation(){
        return $this->belongsTo('App\Models\DocumentSituation',  'document_situation_id');
    }

    public function statusProcessingDocument()
    {
        return $this->belongsTo('App\Models\StatusProcessingDocument', 'status_processing_document_id');
    }

    public function setProcessingDocumentDateAttribute($processing_document_date)
    {
        $this->attributes['processing_document_date'] = Carbon::createFromFormat('d/m/Y', $processing_document_date);
    }

    public function getProcessingDocumentDateAttribute($processing_document_date)
    {
        return $this->asDateTime($processing_document_date)->format('d/m/Y');
    }

    public function adviceSituationDocument()
    {
        return $this->belongsTo('App\Models\AdviceSituationDocuments', 'advice_situation_documents_id');
    }

    public function advicePublicationDocument()
    {
        return $this->belongsTo('App\Models\AdvicePublicationDocuments', 'advice_publication_documents_id');
    }

}
