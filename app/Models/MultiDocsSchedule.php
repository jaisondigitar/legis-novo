<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * @return HasMany
     */
    public function docs(): HasMany
    {
        return $this->hasMany(ScheduleDocs::class);
    }

    /**
     * @return HasOne
     */
    public function multiVoting(): HasOne
    {
        return $this->hasOne(MultiVoting::class);
    }

    /**
     * @return HasOne
     */
    public function meeting(): HasOne
    {
        return $this->hasOne(Meeting::class, 'id', 'meeting_id');
    }
}
