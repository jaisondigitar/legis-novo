<?php

namespace App\Libraries\Repositories;

use App\Models\Company;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CompanyRepository extends Repository
{
    protected $modelClass = Company::class;

    public function search($input)
    {
        $query = Company::query();

        $columns = Schema::getColumnListing('companies');

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
            throw new HttpException(1001, 'Company not found');
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->findByID($id);

        if (empty($model)) {
            throw new HttpException(1001, 'Company not found');
        }

        return $model->delete();
    }
}
