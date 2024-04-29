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

    public function update(int $id, array $attributes): bool
    {
        return $this->model->find($id)->update($attributes);
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    public function where($x, $y)
    {
        return $this->model->where($x, $y)->get();
    }

    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
}
