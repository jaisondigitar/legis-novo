<?php

namespace App\Repositories;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @var string
     */
    protected $modelClass;

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function newQuery()
    {
        return app()->make($this->modelClass)->newQuery();
    }

    /**
     * @param null $query
     * @param int $take
     * @param bool $paginate
     * @return mixed
     * @throws BindingResolutionException
     */
    public function doQuery($query = null, int $take = 20, bool $paginate = true)
    {
        if (! $query) {
            $query = $this->newQuery();
        }

        if ($paginate) {
            return $query->paginate($take);
        }

        if ($take) {
            return $query->take($take)->get();
        }

        return $query->get();
    }

    /**
     * @param int $take
     * @param bool $paginate
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getAll(int $take = 20, bool $paginate = false)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param int $id
     * @param bool $fail
     * @return mixed
     * @throws BindingResolutionException
     */
    public function findByID(int $id, bool $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws BindingResolutionException
     */
    public function findOne(int $id)
    {
        $pk_name = app()->make($this->modelClass)->getKeyName();

        return $this->newQuery()
            ->where($pk_name, $id)
            ->get()
            ->first();
    }

    /**
     * @param array $data
     * @return Model
     * @throws BindingResolutionException
     */
    public function factory(array $data = []): Model
    {
        $model = $this->newQuery()->getModel()->newInstance();

        $this->fillModel($model, $data);

        return $model;
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public function fillModel(Model $model, array $data = []): void
    {
        $model->fill($data);
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function save(Model $model): Model
    {
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @return bool|null
     * @throws Exception
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    /**
     * @param array $data
     * @return Model
     * @throws BindingResolutionException
     */
    public function create(array $data): Model
    {
        $model = $this->factory($data);

        return $this->save($model);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data = []): Model
    {
        $this->fillModel($model, $data);

        return $this->save($model);
    }

    /**
     * @param Model $model
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Model $model): ?bool
    {
        return $this->delete($model);
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function firstInRandomOrder()
    {
        return $this->newQuery()
            ->inRandomOrder()
            ->first();
    }

    /**
     * @param array $filters
     * @param Builder $query
     */
    public function filterByColumns(array $filters, Builder $query)
    {
        foreach ($filters as $column => $value) {
            $query->where($column, $value);
        }
    }
}
