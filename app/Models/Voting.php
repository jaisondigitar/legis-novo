<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voting extends BaseModel
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->open_at = Carbon::now();
        });
    }

    public $table = 'votings';

    protected $fillable = [

        'meeting_id',
        'type_voting_id',
        'open_at',
        'assemblyman_active',
        'law_id',
        'ata_id',
        'advice_id',
        'document_id',
        'closed_at',
        'version_pauta_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function law()
    {
        return $this->belongsTo(LawsProject::class, 'law_id');
    }

    public function advice()
    {
        return $this->belongsTo(Advice::class);
    }

    public function votes()
    {
        return $this->hasMany(Votes::class);
    }

    public function getDocument()
    {
        if ($this->checkDocuemnt()) {
            return $this->law();
        }

        return $this->document();
    }

    public function checkDocuemnt()
    {
        return $this->law_id > 0;
    }

    public function getName()
    {
        if ($this->checkDocuemnt()) {
            $name = 'PROJETO DE LEI : ';

            if (! $this->law->law_type) {
                $name = $name.$this->law->law_type->law_type_id;
            } else {
                $name = $name.mb_strtoupper($this->law->law_type->name, 'UTF-8');
            }

            $name = $name.' '.$this->law->project_number.'/'.$this->law->getYearLawPublish($this->law->law_date);

            return $name;
        } else {
            $name = 'DOCUMENTO : ';

            if ($this->document->document_type->parent_id) {
                $name = $name.$this->document->document_type->parent->name.'::';
            }
            $name = $name.$this->document->document_type->name.'-';

            if ($this->document->number == 0) {
            } else {
                $name = $name.$this->document->number.'/'.$this->document->getYear($this->document->date);
            }

            return $name;
        }
    }

    public function getNameAdvice()
    {
        if ($this->advice->laws_projects_id > 0) {
            $name = 'PROJETO DE LEI : ';

            if (! $this->advice->project->law_type) {
                $name = $name.$this->advice->project->law_type->law_type_id;
            } else {
                $name = $name.mb_strtoupper($this->advice->project->law_type->name, 'UTF-8');
            }

            $name = $name.$this->advice->project->project_number.'/'.$this->advice->project->getYearLawPublish($this->advice->project->law_date);

            return $name;
        } else {
            $name = 'DOCUMENTO: ';

            if ($this->advice->document->document_type->parent_id) {
                $name = $name.$this->advice->document->document_type->parent->name.'::';
            }
            $name = $name.$this->advice->document->document_type->name.'-';

            if ($this->advice->document->number == 0) {
            } else {
                $name = $name.$this->advice->document->number.'/'.$this->advice->document->getYear($this->advice->document->date);
            }

            return $name;
        }
    }

    public function situation($voting)
    {
        if ($voting->votes()->sum('yes') > $voting->votes()->sum('no')) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('closed_at')->first();
    }

    public function scopeLastVoting($query)
    {
        return $query->whereNotNull('closed_at')->get()->last();
    }

    public function getAta()
    {
        if (isset($this->ata_id)) {
            $meeting = Meeting::find($this->ata_id);
        }

        return $meeting->number.'/'.Carbon::createFromFormat('d/m/Y H:i', $meeting->date_start)->year;
    }
}
