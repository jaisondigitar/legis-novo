<?php

namespace App\Repositories;

use App\Models\People;

class PeopleRepository extends Repository
{
    protected $fieldSearchable = [
        'name',
        'cpf',
        'email',
        'celular',
        'zipcode',
        'street',
        'number',
        'complement',
        'district',
        'state_id',
        'city_id',
    ];

    protected $modelClass = People::class;
}
