<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }


}
