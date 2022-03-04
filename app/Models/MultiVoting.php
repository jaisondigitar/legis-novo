<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * @return HasMany
     */
    public function multiDocsVoting(): HasMany
    {
        return $this->hasMany(MultiDocsVoting::class);
    }

    /**
     * @return HasOne
     */
    public function multiDocsSchedule(): HasOne
    {
        return $this->hasOne(
            MultiDocsSchedule::class,
            'id',
            'multi_docs_schedule_id'
        );
    }
}
