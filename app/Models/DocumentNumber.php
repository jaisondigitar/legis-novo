<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\AuditingTrait;

class DocumentNumber extends Model
{

    use AuditingTrait;

    protected $fillable = [

        'user_id',
        'document_id',
        'date'

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function document(){
        return $this->belongsTo(Document::class);
    }

}
