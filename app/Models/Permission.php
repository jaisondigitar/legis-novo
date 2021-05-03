<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use OwenIt\Auditing\AuditingTrait;

class Permission extends Model
{
    use AuditingTrait;
	public $table = "permissions";
    

	public $fillable = [
	    "id",
		"name",
		"readable_name",
		"created_at",
		"updated_at"
	];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "id" => "integer",
		"name" => "string",
		"readable_name" => "string"
    ];

	public static $rules = [
	    
	];



}
