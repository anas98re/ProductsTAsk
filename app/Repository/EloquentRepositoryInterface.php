<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface {

    public function find($id) : ?Model;

    public function create(array $attributes) :Model;

    public function update(array $attributes);

    public function delete($column, $value);
}
