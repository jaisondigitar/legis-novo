<?php

namespace App\Models;

class LawFile extends BaseModel
{
    protected $fillable = [
        'laws_project_id',
        'filename',
    ];

    public function law_project()
    {
        return $this->belongsTo(LawsProject::class);
    }
}
