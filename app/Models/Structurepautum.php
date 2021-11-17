<?php

namespace App\Models;

use Baum\Node;

/**
* Structurepautum
*/
class Structurepautum extends Node {
    protected $table = 'structurepautas';

    protected $parentColumnName = 'parent_id';
    protected $leftColumnName   = 'lft';
    protected $rightColumnName  = 'rgt';
    protected $depthColumnName  = 'depth';
    protected $nameColumn   = 'name';
    protected $orderColumnName  = 'order';

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
