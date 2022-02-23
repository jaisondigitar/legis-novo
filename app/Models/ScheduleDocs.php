<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleDocs extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'schedule_docs';

    /**
     * @var string[]
     */
    public $fillable = [
        'multi_docs_schedule_id',
        'model_type',
        'model_id',
    ];

    /**
     * @return MorphTo
     */
    public function documents(): MorphTo
    {
        return $this->morphTo('model');
    }
}
