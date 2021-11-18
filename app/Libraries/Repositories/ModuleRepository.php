<?php

namespace App\Libraries\Repositories;

use App\Models\Module;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ModuleRepository extends Repository
{
    protected $modelClass = Module::class;

    public function search($input)
    {
        $query = Module::query();

        $columns = Schema::getColumnListing('modules');

        $attributes = [];

        foreach ($columns as $attribute) {
            if (isset($input[$attribute]) and ! empty($input[$attribute])) {
                $query->where($attribute, $input[$attribute]);
                $attributes[$attribute] = $input[$attribute];
            } else {
                $attributes[$attribute] = null;
            }
        }

        return [$query->get(), $attributes];
    }

    public function apiFindOrFail($id)
    {
        $model = $this->findByID($id);

        if (empty($model)) {
            throw new HttpException(1001, 'Module not found');
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->findByID($id);

        if (empty($model)) {
            throw new HttpException(1001, 'Module not found');
        }

        return $model->delete();
    }
}
