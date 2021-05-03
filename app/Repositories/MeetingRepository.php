<?php

namespace App\Repositories;

use App\Models\Meeting;
use InfyOm\Generator\Common\BaseRepository;

class MeetingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'session_type_id',
        'session_place_id',
        'date_start',
        'date_end'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Meeting::class;
    }
}
