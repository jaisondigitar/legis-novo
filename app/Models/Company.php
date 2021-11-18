<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    public $table = 'companies';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'image',
        'shortName',
        'fullName',
        'email',
        'phone1',
        'phone2',
        'mayor',
        'cnpjCpf',
        'ieRg',
        'im',
        'address',
        'city',
        'state',
        'active',
        'stage',
        'assemblyman_id',
        'meeting_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'shortName' => 'string',
        'fullName' => 'string',
        'email' => 'string',
        'phone1' => 'string',
        'phone2' => 'string',
        'mayor' => 'string',
        'cnpjCpf' => 'string',
        'ieRg' => 'string',
        'im' => 'string',
        'city' => 'integer',
        'state' => 'integer',
        'active' => 'boolean',
    ];

    public static $rules = [
        'shortName' => 'required',
        'email' => 'required',
        'phone1' => 'required',
        'phone2' => 'required',
        'mayor' => 'required',
        'cnpjCpf' => 'required',
        'ieRg' => 'required',
        'im' => 'required',
        'city' => 'required',
        'state' => 'required',
    ];

    public function getState()
    {
        return $this->belongsTo('App\Models\State', 'state', 'id');
    }

    public function getCity()
    {
        return $this->belongsTo('App\Models\City', 'city', 'id');
    }
}
