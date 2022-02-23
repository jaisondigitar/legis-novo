<?php

namespace App\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Structurepautum.
 */
class Structurepautum extends Node
{
    protected $table = 'structurepautas';

    protected $parentColumnName = 'parent_id';
    protected $leftColumnName = 'lft';
    protected $rightColumnName = 'rgt';
    protected $depthColumnName = 'depth';
    protected $nameColumn = 'name';
    protected $orderColumnName = 'order';

    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    public $fillable = [
        'parent_id',
        'name',
        'order',
        'add_doc',
        'add_law',
        'add_obs',
        'add_ass',
        'add_advice',
        'version_pauta_id',
        'vote_in_block',
    ];

    public static $rules = [
        'name' => 'required',
    ];

    protected $appends = ['has_open_voting'];

    /**
     * @return HasMany
     */
    public function multiDocsSchedule(): HasMany
    {
        return $this->hasMany(MultiDocsSchedule::class, 'structure_id', 'id');
    }

    public function getHasOpenVotingAttribute()
    {
        if (
            $this->multiDocsSchedule->isNotEmpty() &&
            ! empty($this->multiDocsSchedule->first()->multiVoting)
        ) {
            return (bool) $this->multiDocsSchedule->first()
                ->multiVoting->whereNull('closed_at')->first();
        } elseif (
            $this->meeting->isNotEmpty() &&
            $this->meeting->first()->meeting->isNotEmpty()
        ) {
            $this->meeting->first()->meeting->first()->manyVotes->whereNull('closed_at')
                ->isNotEmpty();
        }
    }

    /**
     * @return HasMany
     */
    public function meeting(): HasMany
    {
        return $this->hasMany(MeetingPauta::class, 'structure_id', 'id');
    }
}
