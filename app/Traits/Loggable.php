<?php

namespace App\Traits;

use App\Models\Activity;
use App\Models\ChangeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

trait Loggable
{
    protected static function bootLoggable()
    {
        $request = app(Request::class);
        $routeName = $request && $request->route() ? $request->route()->uri() : null;
        $ip = $request->ip();
        $user = auth()->user();
        $userName = $user ? $user->nameUser : null;
        $userId = $user ? $user->id_user : null;

        static::creating(function ($model) use ($user, $routeName, $ip, $userName, $userId) {
            Activity::create([
                'model' => get_class($model),
                'action' => 'created',
                'changesData' => json_encode($model->getAttributes(), JSON_UNESCAPED_UNICODE),
                'description' => get_class($model) . ' created by ' . $userName . ', using route: ' . $routeName . ' from IP: ' . $ip,
                'user_id' => $userId,
                'model_id' => $model->getKey(),
                'edit_date' => Carbon::now('Asia/Riyadh')->toDateTimeString(),
                'route' => $routeName,
                'ip' => $ip
            ]);
        });

        static::updating(function ($model) use ($user, $routeName, $ip, $userName, $userId) {
            $originalAttributes = $model->getOriginal();
            $updatedAttributes = $model->getDirty();

            $modifiedAttributes = [];

            foreach ($updatedAttributes as $attribute => $newValue) {
                $oldValue = $originalAttributes[$attribute] ?? null;

                if ($oldValue !== $newValue) {
                    $modifiedAttributes[$attribute] = " ($oldValue) TO ($newValue)";
                }
            }

            Activity::create([
                'model' => get_class($model),
                'action' => 'updated',
                'changesData' => json_encode($modifiedAttributes, JSON_UNESCAPED_UNICODE),
                'description' => get_class($model) . ' updated by ' . $userName . ', using route: ' . $routeName . ' from IP: ' . $ip,
                'user_id' => $userId,
                'model_id' => $model->getKey(),
                'edit_date' => Carbon::now('Asia/Riyadh')->toDateTimeString(),
                'route' => $routeName,
                'ip' => $ip
            ]);
        });

        static::deleting(function ($model) use ($user, $routeName, $ip, $userName, $userId) {
            Activity::create([
                'model' => get_class($model),
                'action' => 'deleted',
                'changesData' => json_encode($model->getOriginal(), JSON_UNESCAPED_UNICODE),
                'description' => get_class($model) . ' deleted by ' . $userName . ', using route: ' . $routeName . ' from IP: ' . $ip,
                'user_id' => $userId,
                'model_id' => $model->getKey(),
                'edit_date' => Carbon::now('Asia/Riyadh')->toDateTimeString(),
                'route' => $routeName,
                'ip' => $ip
            ]);
        });
    }
}
