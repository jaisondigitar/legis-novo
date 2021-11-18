<?php

namespace App\Libraries\Repositories;

use App\Models\State;
use App\Repositories\Repository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StateRepository extends Repository
{
    protected $modelClass = State::class;

    public function search($input)
    {
        $query = State::query();

        $columns = Schema::getColumnListing('states');
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
            throw new HttpException(1001, 'State not found');
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->findByID($id);

        if (empty($model)) {
            throw new HttpException(1001, 'State not found');
        }

        return $model->delete();
    }
}
