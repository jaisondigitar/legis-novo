<?php

namespace App\Models;

use Artesaos\Defender\Traits\HasDefender;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use SoftDeletes, Authenticatable, CanResetPassword, Messagable, HasDefender;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'company_id',
        'sector_id',
        'name',
        'email',
        'password',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'sector_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'active' => 'boolean',
    ];

    public static $rules = [
        'sector_id' => 'required',
        'name' => 'required',
        'email' => 'exists:users,email',
        'password' => 'required',
    ];

    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function sector()
    {
        return $this->belongsTo('App\Models\Sector');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-'.$this->id);
    }

    public function user_assemblyman()
    {
        return $this->hasMany(UserAssemblyman::class, 'users_id');
    }

    public function assemblyman_count()
    {
        return ($this->user_assemblyman()->count() == 1) ? true : false;
    }

    public function get_assemblyman()
    {
        return $this->user_assemblyman()->first()->assemblyman_id;
    }
}
