<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VersionPauta extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
         'name',
         'slug',
     ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (self $versionPauta) {
            $versionPauta->slug = Str::slug($versionPauta->name);
        });

        static::updating(function (self $versionPauta) {
            $versionPauta->slug = Str::slug($versionPauta->name);
        });
    }

    public function structurePauta()
    {
        return $this->hasMany(Structurepautum::class);
    }
}
