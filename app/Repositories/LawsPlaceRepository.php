<?php

namespace App\Repositories;

use App\Models\LawsPlace;
use InfyOm\Generator\Common\BaseRepository;

class LawsPlaceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LawsPlace::class;
    }
}
