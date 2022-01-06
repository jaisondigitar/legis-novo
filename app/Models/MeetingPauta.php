<?php

namespace App\Models;

class MeetingPauta extends BaseModel
{
    public $table = 'meeting_pauta';

    public $fillable = [
        'meeting_id',
        'structure_id',
        'law_id',
        'advice_id',
        'document_id',
        'description',
        'observation',

    ];

    public static $translation = [
        'MEETINGPAUTA' => 'ENCONTRO PAUTA',
        'meeting_id' => 'Id da Reunião',
        'structure_id' => 'Id da Estrutura',
        'law_id' => 'Id da Lei',
        'advice_id' => 'Id da Situação',
        'document_id' => 'Id do Documento',
        'description' => 'Descrição',
        'observation' => 'Observação',
    ];

    public static $rules = [
        'meeting_id' => 'required',
        'structure_id' => 'required',
    ];

    public function document()
    {
        return $this->hasMany(Document::class, 'id', 'document_id');
    }

    public function law()
    {
        return $this->hasMany(LawsProject::class, 'id', 'law_id');
    }

    public function meeting()
    {
        return $this->hasMany(Meeting::class);
    }

    public function advices()
    {
        return $this->hasMany(Advice::class);
    }
}
