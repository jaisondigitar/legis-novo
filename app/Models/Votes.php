<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Votes extends Model
{
    use SoftDeletes;

    public $table = 'votes';

    protected $dates = ['deleted_at'];

    protected $fillable = [

        'voting_id',
        'assemblyman_id',
        'yes',
        'no',
        'abstention',
        'out'
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
        $this->yes=0;
        $this->no=0;
        $this->abstention=0;
        $this->out=0;
        $this->save();
    }

}
