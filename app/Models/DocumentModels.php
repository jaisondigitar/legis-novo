<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="DocumentModels",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="document_type_id",
 *          description="document_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
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
class DocumentModels extends BaseModel
{
    use SoftDeletes;

    public $table = 'document_models';

    public $fillable = [
        'document_type_id',
        'name',
        'content',
        'text_initial',
    ];

    public static $translation = [
        'DOCUMENTMODELS' => 'MODELOS DE DOCUMENTOS',
        'document_type_id' => 'Tipo de Documento',
        'name' => 'Nome',
        'content' => 'Conteúdo',
        'text_initial' => 'Texto Inicial',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'document_type_id' => 'integer',
        'name' => 'string',
        'content' => 'string',
        'text_initial' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'document_type_id' => 'required',
        'name' => 'required',
        'content' => 'required',
        'text_initial' => 'required',
    ];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    /**
     * @param  Builder  $query
     * @param  int  $document_type
     * @return Builder
     */
    public function scopeDocumentModel(Builder $query, int $document_type): Builder
    {
        return $query->where('document_type_id', $document_type);
    }
}
