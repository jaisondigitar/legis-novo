<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

	public $table = "profiles";
    
	protected $dates = ['deleted_at'];


	public $fillable = [
	    "user_id",
		"image",
		"fullName",
		"about",
		"facebook",
		"twitter",
		"linkedin",
		"instagram",
		"city",
		"state",
		"active"
	];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "user_id" => "integer",
		"image" => "string",
		"fullName" => "string",
		"about" => "string",
		"facebook" => "string",
		"twitter" => "string",
		"linkedin" => "string",
		"instagram" => "string",
		"city" => "integer",
		"state" => "integer",
		"active" => "boolean"
    ];

	public static $rules = [
	    "user_id" => "required"
	];



}
