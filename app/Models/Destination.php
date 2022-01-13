<?php

namespace App\Models;

class Destination extends BaseModel
{
    protected $table = 'destinations';

    protected $fillable = [
        'name',
        'email',
    ];

    public static $translation = [
        'DESTINATION' => 'DESTINO',
        'name' => 'Nome',
        'email' => 'E-Mail',
    ];
}
