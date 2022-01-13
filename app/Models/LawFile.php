<?php

namespace App\Models;

class LawFile extends BaseModel
{
    protected $fillable = [
        'laws_project_id',
        'filename',
    ];

    public static $translation = [
        'LAWFILE' => 'ARQUIVO DE LEI',
        'laws_project_id' => 'Referente à',
        'filename' => 'Nome do Arquivo',
    ];

    public function law_project()
    {
        return $this->belongsTo(LawsProject::class);
    }
}
