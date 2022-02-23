<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MultiVoting extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'multi_voting';

    /**
     * @var string[]
     */
    public $fillable = [
        'multi_docs_schedule_id',
        'closed_at',
        'is_open_for_voting',
    ];
}
