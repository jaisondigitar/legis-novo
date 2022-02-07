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

    public static $translation = [
        'name' => 'Nome',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'email' => 'E-Mail',
        'telephone' => 'Telefone',
        'celular' => 'Celular',
        'image' => 'Imagem',
        'zipcode' => 'CEP',
        'street' => 'Rua',
        'number' => 'Número',
        'complement' => 'Complemento',
        'district' => 'Bairro',
        'state_id' => 'Id do Estado',
        'city_id' => 'Id da Cidade',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'celular' => 'required',
    ];
}
