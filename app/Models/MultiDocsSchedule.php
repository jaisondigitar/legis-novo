<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MultiDocsSchedule extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'multi_docs_schedule';

    /**
     * @var string[]
     */
    public $fillable = [
        'meeting_id',
        'structure_id',
        'description',
        'observation',
    ];
}
