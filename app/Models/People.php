<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class People extends BaseModel
{
    use SoftDeletes;

    public $table = 'people';

    public $fillable = [
        'name',
        'cpf',
        'rg',
        'email',
        'telephone',
        'celular',
        'image',
        'zipcode',
        'street',
        'number',
        'complement',
        'district',
        'state_id',
        'city_id',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'cpf' => 'required',
        'zipcode' => 'required',
        'number' => 'required',
        'state_id' => 'required',
        'city_id' => 'required',
    ];
}
