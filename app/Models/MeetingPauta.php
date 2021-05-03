<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\AuditingTrait;

class MeetingPauta extends Model
{
    use AuditingTrait;

    public $table = 'meeting_pauta';

    public $fillable = [
        'meeting_id',
        'structure_id',
        'law_id',
        'advice_id',
        'document_id',
        'description',
        'observation'

    ];

    public static $rules = [
        'meeting_id' => 'required',
        'structure_id' => 'required'
    ];

    public function document()
    {
        return $this->hasMany(Document::class, 'id','document_id');
    }

    public function law()
    {
        return $this->hasMany(LawsProject::class,'id','law_id');
    }

    public function meeting()
    {
        return $this->hasMany(Meeting::class);
    }

    public function advices(){
        return $this->hasMany(Advice::class);
    }


}
