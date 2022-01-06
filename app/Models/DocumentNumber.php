<?php

namespace App\Models;

class DocumentNumber extends BaseModel
{
    protected $fillable = [

        'user_id',
        'document_id',
        'date',

    ];

    public static $translation = [
        'DOCUMENTNUMBER' => 'NÚMERO DO DUCUMENTO',
        'user_id' => 'Id do Usuário',
        'document_id' => 'Id do Documento',
        'date' => 'Data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
