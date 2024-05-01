<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\JsonResponeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends JsonResponeService
{
    public $userService;
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


    public function show($id)
    {
        return $this->userService->showUserService($id);
    }


    public function update(Request $request, $id)
    {
        $user = $this->userService->UserRepository->find($id);
        if (!$user) {
            return $this->sendError('User not found!');
        }
        return $this->userService->updateUserService($request, $id);
    }


    public function destroy($id)
    {
        $user = $this->userService->UserRepository->find($id);
        if (!$user) {
            return $this->sendError('User not found!');
        }
        return $this->userService->deleteUserService($id) ?
            $this->sendSucssas('Product deleted successfully.') :
            $this->sendError('There is a problem deleting');
    }
}
