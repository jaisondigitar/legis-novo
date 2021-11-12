<?php namespace App\Libraries\Repositories;

use App\Models\City;
use App\Repositories\Repository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CityRepository extends Repository
{
    protected $modelClass = City::class;

	public function search($input)
    {
        $query = City::query();

        $columns = Schema::getColumnListing('cities');
        $attributes = array();

        foreach($columns as $attribute)
        {
            if(isset($input[$attribute]) and !empty($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
                $attributes[$attribute] = $input[$attribute];
            }
            else
            {
                $attributes[$attribute] =  null;
            }
        }

        return [$query->get(), $attributes];
    }

    public function apiFindOrFail($id)
    {
        $model = $this->find($id);

        if(empty($model))
        {
            throw new HttpException(1001, "City not found");
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->find($id);

        if(empty($model))
        {
            throw new HttpException(1001, "City not found");
        }

        return $model->delete();
    }
}
