<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawProjectsNumber extends Model
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
