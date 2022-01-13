<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Meeting",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="session_type_id",
 *          description="session_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="session_place_id",
 *          description="session_place_id",
 *          type="integer",
 *          format="int32"
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
class Meeting extends BaseModel
{
    use SoftDeletes;

    public $table = 'meetings';

    public $fillable = [
        'session_type_id',
        'session_place_id',
        'date_start',
        'date_end',
        'number',
        'version_pauta_id',
    ];

    public static $translation = [
        'MEETING' => 'ENCONTRO',
        'session_type_id' => 'id do Tipo de Sessão',
        'session_place_id' => 'id do Local da Sessão',
        'date_start' => 'Data Inicio',
        'date_end' => 'Data Final',
        'number' => 'Número',
        'version_pauta_id' => 'Id da Estrutura da Pauta',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'session_type_id' => 'integer',
        'session_place_id' => 'integer',
        'number' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public function session_type()
    {
        return $this->belongsTo(SessionType::class, 'session_type_id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\MeetingFiles', 'meeting_id', 'id');
    }

    public function meeting_pauta()
    {
        return $this->hasMany(MeetingPauta::class);
    }

    public function laws()
    {
        return $this->belongsToMany(LawsProject::class, 'meeting_pauta', 'meeting_id', 'law_id');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'meeting_pauta', 'meeting_id', 'document_id');
    }

    public function session_place()
    {
        return $this->belongsTo(SessionPlace::class, 'session_place_id');
    }

    public function setDateStartAttribute($date_start)
    {
        $this->attributes['date_start'] = Carbon::createFromFormat('d/m/Y H:i', $date_start);
    }

    public function getDateStartAttribute($date_start)
    {
        return $this->asDateTime($date_start)->format('d/m/Y H:i');
    }

    public function setDateEndAttribute($date_end)
    {
        $this->attributes['date_end'] = Carbon::createFromFormat('d/m/Y H:i', $date_end);
    }

    public function getDateEndAttribute($date_end)
    {
        return $this->asDateTime($date_end)->format('d/m/Y H:i');
    }

    public function scopeByIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeByDateDesc($query)
    {
        return $query->orderBy('date_start', 'desc');
    }

    public function assemblyman()
    {
        return $this->belongsToMany(Assemblyman::class, 'meeting_presences', 'meeting_id', 'assemblymen_id');
    }

    public function hasAssemblyman($assemblyman)
    {
        return $assemblyman->meeting()->count();
    }

    public function voting()
    {
        return $this->hasOne(Voting::class);
    }

    public function situation($id, $type)
    {
        if ($type == 'law') {
            if ($this->voting()->where('law_id', $id)->first()->votes()->sum('yes') > $this->voting()->where('law_id', $id)->first()->votes()->sum('no')) {
                return true;
            } else {
                return false;
            }
        }

        if ($type == 'document') {
            if ($this->voting()->where('document_id', $id)->first()->votes()->sum('yes') > $this->voting()->where('document_id', $id)->first()->votes()->sum('no')) {
                return true;
            } else {
                return false;
            }
        }

        if ($type == 'ata') {
            if ($this->voting()->where('ata_id', $id)->count() > 0) {
                if ($this->voting()->where('ata_id', $id)->first()->votes()->sum('yes') > $this->voting()->where('ata_id', $id)->first()->votes()->sum('no')) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        if ($type == 'advice') {
            if ($this->voting()->where('advice_id', $id)->count() > 0) {
                if ($this->voting()->where('advice_id', $id)->first()->votes()->sum('yes') > $this->voting()->where('advice_id', $id)->first()->votes()->sum('no')) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function version_pauta()
    {
        return $this->belongsTo(VersionPauta::class);
    }

    public function getDataMesa($data)
    {
        $data = explode(' ', $data);
        $data = $data[0];

        $data = explode('/', $data);

        $dia = $data[0];
        $mes = $data[1];
        $ano = $data[2];

        $data = $ano.'-'.$mes.'-'.$dia;

        return $data;
    }
}
