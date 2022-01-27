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
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, Auditable
{
    use SoftDeletes, Authenticatable, CanResetPassword, Messagable, HasDefender, AuditTrait;

    public $table = 'users';

    public $fillable = [
        'id',
        'company_id',
        'sector_id',
        'name',
        'email',
        'password',
        'active',
    ];

    public static $translation = [
        'USER' => 'USUÁRIO',
        'id' => 'ID',
        'company_id' => 'ID da Empresa',
        'sector_id' => 'Id do Setor',
        'name' => 'Nome',
        'email' => 'E-Mail',
        'password' => 'Senha',
        'active' => 'Ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

    /**
     * @return bool
     */
    public function getCanRequestLegalOpinionAttribute(): bool
    {
        if ($this->sector) {
            return $this->sector->name === 'Jurídico';
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getCanRequestSecretaryAttribute(): bool
    {
        if ($this->sector) {
            return $this->sector->name === 'Secretaria' || $this->hasRole('root');
        }

        return false;
    }
}
