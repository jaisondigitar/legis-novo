<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Assemblyman",
 *      required={companies_id, short_name, email, phone1, state_id, city_id},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="companies_id",
 *          description="companies_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="short_name",
 *          description="short_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="full_name",
 *          description="full_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone1",
 *          description="phone1",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone2",
 *          description="phone2",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="official_document",
 *          description="official_document",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="general_register",
 *          description="general_register",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="street",
 *          description="street",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          description="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="complement",
 *          description="complement",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="district",
 *          description="district",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="state_id",
 *          description="state_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="city_id",
 *          description="city_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="zipcode",
 *          description="zipcode",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Assemblyman extends Model
{
    use SoftDeletes;

    public $table = 'assemblymen';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'companies_id',
        'image',
        'short_name',
        'full_name',
        'email',
        'phone1',
        'phone2',
        'official_document',
        'general_register',
        'street',
        'number',
        'complement',
        'district',
        'state_id',
        'city_id',
        'active',
        'zipcode'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'companies_id' => 'integer',
        'image' => 'string',
        'short_name' => 'string',
        'full_name' => 'string',
        'email' => 'string',
        'phone1' => 'string',
        'phone2' => 'string',
        'official_document' => 'string',
        'general_register' => 'string',
        'street' => 'string',
        'number' => 'string',
        'complement' => 'string',
        'district' => 'string',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'zipcode' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'companies_id' => 'required',
        'short_name' => 'required',
        'email' => 'required',
        'phone1' => 'required',
        'state_id' => 'required',
        'city_id' => 'required'
    ];

    public function company(){
        return $this->belongsTo('App\Models\Company', 'companies_id');
    }

    public function getState(){
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function legislature_assemblyman(){
        return $this->hasMany(LegislatureAssemblyman::class, 'assemblyman_id');
    }

    public function party_assemblyman(){
        return $this->hasMany(PartiesAssemblyman::class, 'assemblyman_id');
    }

    public function responsibility_assemblyman(){
        return $this->hasMany(ResponsibilityAssemblyman::class, 'assemblyman_id');
    }

    public function user_assemblyman(){
        return $this->hasMany(UserAssemblyman::class, 'assemblyman_id');
    }

    public function commision_assemblyman(){
        return $this->hasMany('\App\Models\CommissionAssemblyman', 'assemblyman_id');
    }

    public function meeting(){
        return $this->belongsToMany(Meeting::class, 'meeting_presences', 'assemblymen_id', 'meeting_id');
    }

//    public function commissions(){
//        return $this->hasManyThrough(Commission::class,CommissionAssemblyman::class, 'commission_id', 'assemblyman_id');
//    }

}
