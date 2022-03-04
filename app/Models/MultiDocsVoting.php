<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MultiDocsVoting extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'multi_docs_voting';

    /**
     * @var string[]
     */
    public $fillable = [
        'multi_voting_id',
        'assemblymen_id',
        'vote',
    ];
}
