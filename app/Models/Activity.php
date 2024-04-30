<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activity_log';
    protected $fillable = [
        'model',
        'action',
        'changesData',
        'description',
        'user_id',
        'model_id',
        'edit_date',
        'source',
        'route',
        'ip',
        'afterApprove'
    ];
}
