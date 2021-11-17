<?php

namespace App\Models;

use Baum\Node;

class StructureLaws extends Node
{
    public $table = 'structure_laws';

    protected $parentColumnName = 'parent_id';
    protected $leftColumnName   = 'lft';
    protected $rightColumnName  = 'rgt';
    protected $depthColumnName  = 'depth';
    protected $orderColumnName   = 'content';

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
