<?php

namespace App\Repositories;

use App\Models\Party;

class PartyRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'prefix',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Party::class;
    }
}
