<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentSector extends BaseModel
{
    use SoftDeletes;

    protected $table = 'documents_sectors';

    public static $rules = [
        'document_id' => 'required',
        'sector_id' => 'required',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
