<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeVoting extends Model
{

    use SoftDeletes;

    public $table = 'type_votings';


    protected $dates = ['deleted_at'];


    protected $fillable = [

        'name',
        'anonymous',
        'active'

    ];

}
