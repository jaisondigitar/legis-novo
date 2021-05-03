<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\AuditingTrait;

class LawProjectsNumber extends Model
{
    use AuditingTrait;

    protected $fillable = [

        'laws_project_id',
        'date'

    ];

    public function lawProject(){
        return $this->belongsTo(LawsProject::class);
    }
}
