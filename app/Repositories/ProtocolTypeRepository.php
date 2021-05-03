<?php

namespace App\Repositories;

use App\Models\ProtocolType;
use InfyOm\Generator\Common\BaseRepository;

class ProtocolTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProtocolType::class;
    }
}
