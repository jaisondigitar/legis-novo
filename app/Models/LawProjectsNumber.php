<?php

namespace App\Models;

class LawProjectsNumber extends BaseModel
{
    protected $fillable = [

        'laws_project_id',
        'date',

    ];

    public function lawProject()
    {
        return $this->belongsTo(LawsProject::class);
    }
}
