<?php

namespace App\Repositories;

use App\Models\Party;
use InfyOm\Generator\Common\BaseRepository;

class PartyRepository extends BaseRepository
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
