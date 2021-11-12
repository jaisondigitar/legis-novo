<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

	public $table = "modules";
    
	protected $dates = ['deleted_at'];


	public $fillable = [
	    "name",
		"token",
		"active"
	];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "name" => "string",
		"token" => "string",
		"active" => "boolean"
    ];

	public static $rules = [
	    "name" => "required"
	];

    public function isActive($module){
        return Module::where('name',$module)->first()->active;
    }


}
