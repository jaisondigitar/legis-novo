<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Votes extends BaseModel
{
    use SoftDeletes;

    public $table = 'votes';

    protected $fillable = [

        'voting_id',
        'assemblyman_id',
        'yes',
        'no',
        'abstention',
        'out',
    ];

    public function voting()
    {
        return $this->belongsTo(Voting::class);
    }

    public function assemblyman()
    {
        return $this->belongsTo(Assemblyman::class);
    }

    public function reset()
    {
        $this->yes = 0;
        $this->no = 0;
        $this->abstention = 0;
        $this->out = 0;
        $this->save();
    }
}
