<?php

namespace App\Models;

class Destination extends BaseModel
{
    protected $table = 'destinations';

    protected $fillable = ['name', 'email'];
}
