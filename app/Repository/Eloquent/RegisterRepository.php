<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\RegisterRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RegisterRepository extends BaseRepository implements RegisterRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }


}
