<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
    use SoftDeletes;

    public $table = 'people';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'cpf',
        'rg',
        'email',
        'telephone',
        'celular',
        'zipcode',
        'street',
        'number',
        'complement',
        'district',
        'state_id',
        'city_id',
    ];

    protected $casts = [
        'name' => 'string',
        'cpf' => 'string',
        'rg' => 'string',
        'address' => 'string',
        'email' => 'string',
        'telephone' => 'string',
        'celular' => 'string',
        'zipcode' => 'string',
        'street' => 'string',
        'number' => 'string',
        'complement' => 'string',
        'district' => 'string',
        'state_id' => 'string',
        'city_id' => 'string',
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
