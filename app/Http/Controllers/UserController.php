<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\JsonResponeService;
use App\Services\UserService;

class UserController extends JsonResponeService
{
    private $userService;
    public function __construct(UserService $userService)
    {
        //Only the admin with the gold type can control functions for a user
        $this->middleware(function ($request, $next) {
            if (auth()->user()->type !== 'gold') {
                return $this->sendForbiddenResponse('You are not authorized to access this resource.');
            }
            return $next($request);
        })->only(['index', 'store', 'show', 'update', 'destroy']);

        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->getAllUsersService();
    }


    public function store(StoreUserRequest $request)
    {
        return $this->userService->addUserService($request);
    }


    public function show(User $user)
    {
        //
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }


    public function destroy(User $user)
    {
        //
    }
}
