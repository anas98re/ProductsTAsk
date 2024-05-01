<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repository\Eloquent\RegisterRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserService extends JsonResponeService
{
    public $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function getAllUsersService()
    {
        $data = $this->UserRepository->all();

        return $this->sendResponse(UserResource::collection($data), 'All Users');
    }

    public function addUserService($request)
    {
        $input = $request->all();
        if ($request->hasFile('avatar')) {
            $fileHandled = $request->file('avatar')->store('Users_Avatar', 'public');
            $input['avatar'] = $fileHandled;
        }
        $input['password'] = Hash::make($input['password']);
        $User = $this->UserRepository->create($input);

        $token = $User->createToken('MyAuthApp')->plainTextToken;
        $User['token'] = $token;
        return $this->sendResponse(new UserResource($User), 'Created Done');
    }

    public function showUserService($id)
    {
        $User = $this->UserRepository->find($id);
        return $this->sendResponse(new UserResource($User), 'User Data');
    }

    public function updateUserService($request, $id)
    {
        $User = $this->UserRepository->find($id);

        $User->name = $request->name ?? $User->name;
        $User->username = $request->username ?? $User->username;
        $User->type = $request->type ?? $User->type;
        $User->save();

        if ($request->hasFile('avatar')) {
            $fileHandled = $request->file('avatar')->store('Users_Avatar', 'avatar');
            $User->avatar = $fileHandled;
            $User->save();

            Storage::delete($fileHandled);
        }

        return $this->sendResponse(new UserResource($User), 'User updated successfully.');

    }

    public function deleteUserService($id)
    {
        return true ? $this->UserRepository->deleteUser($id) : false;
    }
}
