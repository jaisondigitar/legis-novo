<?php

namespace App\Models;

class DocumentNumber extends BaseModel
{
    protected $fillable = [

        'user_id',
        'document_id',
        'date',

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
