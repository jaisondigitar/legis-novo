<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class BaseModel extends Model implements Auditable
{
    use AuditableTrait;

    protected $dates = ['deleted_at', 'updated_at', 'created-at'];

    public function scopeFilterByColumns($query)
    {
        $schema = DB::getSchemaBuilder();

        foreach (request()->all() as $key => $value) {
            if (Schema::hasColumn($this->table, $key) && ! empty($value)) {
                switch ($schema->getColumnType($this->table, $key)) {
                    case 'integer':
                        $query->where($key, $value);
                    break;
                    case 'datetime':
                        if (strlen($value) === 4) {
                            $query->whereYear($key, '=', $value);
                        } else {
                            $query->whereDate(
                                $key,
                                '=',
                                Carbon::parse(str_replace('/', '-', $value))
                                    ->format('Y-m-d')
                            );
                        }
                    break;
                    default:
                        $query->where($key, 'like', "%{$value}%");
                }
            }
        }
    }

    public function scopeFilterByRelation(
        $query,
        string $relation_name,
        string $column_name,
        string $column_type,
        $filter,
        string $operator = '='
    ) {
        if ($filter) {
            $query->whereHas(
                $relation_name,
                function ($q) use ($filter, $column_name, $operator, $column_type) {
                    switch ($column_type) {
                        case 'date':
                            $q->whereDate(
                                $column_name,
                                $operator,
                                Carbon::parse(str_replace('/', '-', $filter))
                                    ->format('Y-m-d')
                            );
                            break;
                        default:
                            $q->where($column_name, $operator, $filter);
                    }
                }
            );
        }
    }

    public function scopeHasRelation($query, string $relation_name)
    {
        $query->whereHas($relation_name);
    }
}
