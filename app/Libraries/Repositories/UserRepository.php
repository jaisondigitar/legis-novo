<?php

namespace App\Libraries\Repositories;

use App\Models\User;
use App\Repositories\Repository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserRepository extends Repository
{
    protected $modelClass = User::class;

    public function search($input)
    {
        $query = User::query();

        $columns = Schema::getColumnListing('users');
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
        $model = $this->find($id);

        if (empty($model)) {
            throw new HttpException(1001, 'User not found');
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->find($id);

        if (empty($model)) {
            throw new HttpException(1001, 'User not found');
        }

        return $model->delete();
    }
}
