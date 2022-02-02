<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Document",
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
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          description="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="session_date",
 *          description="session_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="read",
 *          description="read",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="approved",
 *          description="approved",
 *          type="boolean"
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
class DocumentFiles extends BaseModel
{
    use SoftDeletes;

    public $table = 'document_files';

    public $fillable = [
        'document_id',
        'filename',
    ];

    public static $translation = [
        'DOCUMENTFILES' => 'ARQUIVOS DOCUMENTO',
        'document_id' => 'Id do Documento',
        'filename' => 'Nome do Arquivo',
        'id' => 'Id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'document_id' => 'integer',
        'filename' => 'varchar',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id');
    }
}
