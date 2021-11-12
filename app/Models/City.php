<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class City extends Model
{
	public $table = "cities";
    

	public $fillable = [
	    "id",
		"code",
		"state",
		"name",
		"created_at",
		"updated_at",
		"deleted_at"
	];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "id" => "integer",
		"code" => "integer",
		"state" => "string",
		"name" => "string"
    ];

	public static $rules = [
	    
	];



}
