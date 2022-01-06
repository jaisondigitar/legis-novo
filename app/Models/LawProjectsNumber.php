<?php

namespace App\Models;

class LawProjectsNumber extends BaseModel
{
    protected $fillable = [
        'laws_project_id',
        'date',
    ];

    public static $translation = [
        'LAWPROJECTSNUMBER' => 'NÚMERO DE PROJETOS DE LEI',
        'laws_project_id' => 'Referente à',
        'date' => 'Data',
    ];

    public function lawProject()
    {
        return $this->belongsTo(LawsProject::class);
    }
}
