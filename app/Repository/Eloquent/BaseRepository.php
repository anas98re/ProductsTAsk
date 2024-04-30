<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes)
    {
        return $this->model->update($attributes);
    }


    public function delete($column, $value)
    {
        return $this->model->where($column, $value)->delete();
    }

    public function where($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
}
