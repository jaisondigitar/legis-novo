<?php

namespace App\Repositories;

use App\Models\Assemblyman;

class AssemblymanRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'image',
        'short_name',
        'full_name',
        'email',
        'phone1',
        'phone2',
        'official_document',
        'general_register',
        'street',
        'number',
        'complement',
        'district',
        'state_id',
        'city_id',
        'zipcode',
    ];

    protected $modelClass = Assemblyman::class;
}
