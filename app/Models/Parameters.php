<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Parameters",
 *      required={""},
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
 *          property="type",
 *          description="type",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="value",
 *          description="value",
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
class Parameters extends BaseModel
{
    use SoftDeletes;

    public $table = 'parameters';

    public $fillable = [
        'name',
        'type',
        'slug',
        'value',
    ];


    public static $translation = [
        'PARAMETERS' => 'PARÂMETROS',
        'name' => 'Nome',
        'type' => 'Tipo',
        'slug' => 'Sigla',
        'value' => 'Valor',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'type' => 'integer',
        'slug' => 'string',
        'value' => 'string',
    ];

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getShowHeaderAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getSpaceBetweenTextAndHeaderAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'espaco-entre-texto-e-cabecalho')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getMarginTopDocsAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'margem-superior-de-documentos')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getMarginBottomDocsAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'margem-inferior-de-documentos')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getMarginLeftDocsAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'margem-esquerda-de-documentos')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getMarginRightDocsAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'margem-direita-de-documentos')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getPerformDocsAdvicesAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'realiza-tramite-em-documentos')
            ->first()
            ->value;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getShowDocsVotesAttribute()
    {
        return $this->newQuery()
            ->where('slug', 'mostra-votacao-em-documento')
            ->first()
            ->value;
    }
}
