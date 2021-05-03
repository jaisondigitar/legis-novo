<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\AuditingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeVoting extends Model
{

    use SoftDeletes;

    use AuditingTrait;

    public $table = 'type_votings';


    protected $dates = ['deleted_at'];


    protected $fillable = [

        'name',
        'anonymous',
        'active'

    ];

}
