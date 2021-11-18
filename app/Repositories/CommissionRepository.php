<?php

namespace App\Repositories;

use App\Models\Commission;

class CommissionRepository extends Repository
{
    /**
     * @var string
     */
    protected $modelClass = Commission::class;
}
