<?php

namespace App\Repositories;

use App\Models\Party;

class PartyRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'companies_id',
        'prefix',
        'name',
    ];

    protected $modelClass = Party::class;
}
