<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use OwenIt\Auditing\AuditingTrait;


class LawsProjectAssemblyman extends Model
{
    use AuditingTrait;

    public $table = 'law_project_assemblyman';

    public $fillable = [
        'law_project_id',
        'assemblyman_id'
    ];


    protected $casts = [

    ];


    public static $rules = [

    ];

    public function assemblyman(){
        return $this->belongsTo('App\Models\Assemblyman',  'assemblyman_id');
    }
}
