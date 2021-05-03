<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawFile extends Model
{
    protected $fillable = [
        'laws_project_id',
        'filename'
    ];

    public function law_project()
    {
        return $this->belongsTo(LawsProject::class);
    }
}
