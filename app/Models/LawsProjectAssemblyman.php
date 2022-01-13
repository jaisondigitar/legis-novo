<?php

namespace App\Models;

class LawsProjectAssemblyman extends BaseModel
{
    public $table = 'law_project_assemblyman';

    public $fillable = [
        'law_project_id',
        'assemblyman_id',
    ];

    public static $translation = [
        'LAWSPROJECTASSEMBLYMAN' => 'ASSEMBLÉIA DE PROJETOS DE LEIS',
        'law_project_id' => 'Id da Lei do Projeto',
        'assemblyman_id' => 'Id do Responsável',
    ];

    protected $casts = [

    ];

    public static $rules = [

    ];

    public function assemblyman()
    {
        return $this->belongsTo('App\Models\Assemblyman', 'assemblyman_id');
    }
}
