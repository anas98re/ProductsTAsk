<?php

namespace App\Repository;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function deleteUser($id);
}
