<?php

namespace App\Libraries\Repositories;

use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleRepository extends Repository
{
    protected $modelClass = Role::class;

    public function search($input)
    {
        $query = Role::query();

        $columns = Schema::getColumnListing('roles');

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
            throw new HttpException(1001, 'Role not found');
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->findByID($id);

        if (empty($model)) {
            throw new HttpException(1001, 'Role not found');
        }

        return $model->delete();
    }
}
