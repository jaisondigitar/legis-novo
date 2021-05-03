<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\AuditingTrait;
use Baum\Node as Tree;

class StructureLaws extends Tree
{
    use AuditingTrait;

    public $table = 'structure_laws';

    protected $parentColumn = 'parent_id';
    protected $leftColumn   = 'lft';
    protected $rightColumn  = 'rgt';
    protected $depthColumn  = 'depth';
    protected $nameColumn   = 'content';

    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

    public $fillable = [
        'law_id',
        'law_structure_id',
        'parent_id',
        'order',
        'number',
        'content'
    ];

    protected $casts = [
        'law_id' => 'integer',
        'law_structure_id' => 'integer',
        'parent_id' => 'integer',
        'order' => 'integer',
        'number' => 'text',
        'content' => 'text',
    ];


    public static $rules = [
        'law_id' => 'required',
        'law_structure_id' => 'required'
    ];

    public function scopeIsRoot($query){
        return $query->whereNull('parent_id');
    }

    public function type()
    {
        return $this->belongsTo('\App\Models\LawsStructure','law_structure_id');
    }

}
