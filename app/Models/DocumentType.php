<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="DocumentType",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="prefix",
 *          description="prefix",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
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
class DocumentType extends BaseModel
{
    use SoftDeletes;

    public $table = 'document_types';

    public $fillable = [
        'parent_id',
        'name',
        'prefix',
        'slug',
    ];

    public static $translation = [
        'DOCUMENTTYPE' => 'TIPO DE DOCUMENTO',
        'parent_id' => 'Id dos Pais',
        'name' => 'Nome',
        'prefix' => 'Prefixo',
        'slug' => 'Sigla',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'prefix' => 'string',
        'slug' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function hasChilds()
    {
        return count($this->childs) > 0 ? true : false;
    }

    public function getChildsIds()
    {
        $id[] = $this->id;
        foreach ($this->childs as $child) {
            $id[] = $child->id;
        }

        return $id;
    }

    public function childs()
    {
        return $this->hasMany('App\Models\DocumentType', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\DocumentType', 'parent_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
