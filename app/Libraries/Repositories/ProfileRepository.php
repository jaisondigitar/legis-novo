<?php namespace App\Libraries\Repositories;

use App\Models\Profile;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProfileRepository extends Repository
{
    protected $modelClass = Profile::class;

	public function search($input)
    {
        $query = Profile::query();

        $columns = Schema::getColumnListing('profiles');

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
        $model = $this->findByID($id);

        if(empty($model))
        {
            throw new HttpException(1001, "Profile not found");
        }

        return $model;
    }

    public function apiDeleteOrFail($id)
    {
        $model = $this->findByID($id);

        if(empty($model))
        {
            throw new HttpException(1001, "Profile not found");
        }

        return $model->delete();
    }
}
