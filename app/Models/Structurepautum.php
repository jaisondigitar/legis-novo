<?php

namespace App\Models;

use Baum\Node;

/**
* Structurepautum
*/
class Structurepautum extends Node {
    protected $table = 'structurepautas';

    protected $parentColumn = 'parent_id';
    protected $leftColumn   = 'lft';
    protected $rightColumn  = 'rgt';
    protected $depthColumn  = 'depth';
    protected $nameColumn   = 'name';
    protected $orderColumn  = 'order';

    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

    public $fillable = [
        'parent_id',
        'name',
        'order',
        'add_doc',
        'add_law',
        'add_obs',
        'add_ass',
        'add_advice',
        'version_pauta_id'
    ];

    public static $rules = [
        'name' => 'required',
    ];

}
