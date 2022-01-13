<?php

namespace App\Models;

/**
 * @SWG\Definition(
 *      definition="ResponsibilityAssemblyman",
 *      required={},
 *      @SWG\Property(
 *          property="responsibility_id",
 *          description="responsibility_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="assemblyman_id",
 *          description="assemblyman_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="date",
 *          type="string",
 *          format="date"
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
class UserAssemblyman extends BaseModel
{
    public $table = 'user_assemblyman';

    public $fillable = [
        'users_id',
        'assemblyman_id',
    ];

    public static $translation = [
        'USERASSEMBLYMAN' => 'ASSEMBLYMAN DO USUÁRIO',
        'users_id' => 'Id do Usuário',
        'assemblyman_id' => 'Id do Responsável',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'users_id' => 'integer',
        'assemblyman_id' => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function assemblyman()
    {
        return $this->belongsTo(Assemblyman::class, 'assemblyman_id');
    }
}
