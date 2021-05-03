<?php

namespace App\Repositories;

use App\Models\Assemblyman;
use InfyOm\Generator\Common\BaseRepository;

class AssemblymanRepository extends BaseRepository
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
        'zipcode'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Assemblyman::class;
    }
}
