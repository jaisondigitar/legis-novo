<?php

namespace App\Repositories;

use App\Models\AdviceAwnser;
use InfyOm\Generator\Common\BaseRepository;

class AdviceAwnserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'advice_id',
        'commission_id',
        'date',
        'description',
        'file'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdviceAwnser::class;
    }
}
